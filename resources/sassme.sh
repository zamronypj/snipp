#!/bin/bash

if [ $# -ne 1 ]
then
    echo "Usage: $(basename $0) [THEME]"
    exit 1
fi

theme=$1
appRootDir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && cd ".." && pwd )"
sourceScss="$appRootDir/resources/styles/$theme/scss/style.scss"
targetCssDir="$appRootDir/public/assets/$theme/css"
targetCss="$targetCssDir/style.css"

if [ ! -d $targetCssDir ]
then
    mkdir $targetCssDir
fi

if [ ! -f $sourceScss ]
then
    echo "$sourceScss is not found!"
    exit 2;
fi

sass $sourceScss $targetCss