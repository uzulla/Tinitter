<?php declare(strict_types=1);

namespace Tinitter\Misc;

// modify from WyriHaximus\React\Http\Middleware\WebrootPreloadMiddleware;
/*
 original is
    "name": "wyrihaximus/react-http-middleware-session",
    "description": "react/http middleware that takes care of session handling",
    "license": "MIT",
    "authors": [
        {
            "name": "Cees-Jan Kiewiet",
            "email": "ceesjank@gmail.com"
        }
    ],
 */
use WyriHaximus\React\Http\Middleware;
use Narrowspark\Mimetypes\MimeTypeByExtensionGuesser;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use RingCentral\Psr7\Response;
use ScriptFUSION\Byte\ByteFormatter;
use function RingCentral\Psr7\stream_for;

class PatchedWebrootPreloadMiddleware
{
    /**
     * @var array
     */
    private $files = [];

    public function __construct(string $webroot, LoggerInterface $logger = null)
    {
        $totalSize = 0;
        $byteFormatter = (new ByteFormatter())->setPrecision(2)->setFormat('%v%u');
        $directory = new \RecursiveDirectoryIterator($webroot);
        $directory = new \RecursiveIteratorIterator($directory);
        $directory = iterator_to_array($directory);
        usort($directory, function ($a, $b) {
            return $a->getPathname() <=> $b->getPathname();
        });
        foreach ($directory as $fileinfo) {
            if (!$fileinfo->isFile()) {
                continue;
            }

            $filePath = str_replace(
                [
                    $webroot,
                    DIRECTORY_SEPARATOR,
                    '//',
                ],
                [
                    DIRECTORY_SEPARATOR,
                    '/',
                    '/',
                ],
                $fileinfo->getPathname()
            );

            $this->files[$filePath] = [
                'contents' => file_get_contents($fileinfo->getPathname()),
            ];

            $mime = MimeTypeByExtensionGuesser::guess($fileinfo->getExtension());
            // quick fix...
            if(is_null($mime)){
                $mime = 'text/plain';
            }
            // /quick fix...
            list($mime) = explode(';', $mime);
            if (strpos($mime, '/') !== false) {
                $this->files[$filePath]['mime'] = $mime;
            }

            if ($logger instanceof LoggerInterface) {
                $fileSize = strlen($this->files[$filePath]['contents']);
                $totalSize += $fileSize;
                $logger->debug($filePath . ': ' . $byteFormatter->format($fileSize));
            }
        }

        if ($logger instanceof LoggerInterface) {
            $logger->info('Preloaded ' . count($this->files) . ' file(s) with a combined size of ' . $byteFormatter->format($totalSize) . ' from "' . $webroot . '" into memory');
        }
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $path = $request->getUri()->getPath();
        if (!isset($this->files[$path])) {
            return $next($request);
        }

        $response = (new Response(200))->withBody(stream_for($this->files[$path]['contents']));
        if (!isset($this->files[$path]['mime'])) {
            return $response;
        }

        return $response->withHeader('Content-Type', $this->files[$path]['mime']);
    }
}
