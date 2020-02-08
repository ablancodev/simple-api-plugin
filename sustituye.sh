#!/bin/bash
find . -type f -name "*.php" -print0 | xargs -0  sed -i '' -e 's/simple-api-plugin/tuplugin/g';
find . -type f -name "*.php" -print0 | xargs -0  sed -i '' -e 's/SimpleAPIPplugin/TuPlugin/g';
find . -type f -name "*.php" -print0 | xargs -0  sed -i '' -e 's/SIMPLE_API_PLUGIN/TU_PLUGIN/g';
