#!/bin/bash
function finish () {
  cd -
  rm -rf $RUNPACKDIR
  exit
}

RUNPACKDIR=`mktemp -d /tmp/runpackphp.XXXXX`
trap 'finish' {1,2,3,15}
ENDLINE=$(grep --line-number --text "^##ENDLINE$" $0 | sed 's/:.*//')
: $((ENDLINE++))
tail -n +$ENDLINE $0 | tar xzf - --directory $RUNPACKDIR
cd $RUNPACKDIR
$RUNPACKDIR/php $RUNPACKDIR/main.php
cd -
exit
##ENDLINE
