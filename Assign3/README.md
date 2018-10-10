Assign 3 of course CS252

Contributions:
Everyone displayed marker in the app and build the app on their own laptop

Download github repo
npm install
ionic serve --lab --browser firefox
//allow permissions on firefox

Publishing app:
./build.sh


build.sh:
export ANDROID_HOME="~/Android/Sdk"
export PATH=${PATH}:$ANDROID_HOME/tools:$ANDROID_HOME/platform-tools
ionic cordova build android
cp platforms/android/app/build/outputs/apk/debug/app-debug.apk app.apk


The generated apk file is present in the current directory <path>/Assign3/
