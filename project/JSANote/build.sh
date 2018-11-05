export ANDROID_HOME="/home/sahil/Android/Sdk"
export PATH=${PATH}:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools
ionic cordova build android
cp platforms/android/app/build/outputs/apk/debug/app-debug.apk app.apk