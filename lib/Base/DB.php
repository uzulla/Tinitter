<?php
namespace Base;
class DB
{
    /**
     * IlluminateのDB接続設定とブートアップ
     * @param array $settings 接続設定
     */
    public static function registerIlluminate(array $settings)
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($settings);
//        $capsule->setEventDispatcher(
//            new \Illuminate\Events\Dispatcher(
//                new \Illuminate\Container\Container()
//            )
//        );
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
