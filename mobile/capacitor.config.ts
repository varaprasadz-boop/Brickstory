import type { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.brickstory.app',
  appName: 'BrickStory',
  webDir: 'www',
  plugins: {
    CapacitorHttp: {
      enabled: true,
    },
    EdgeToEdge: {
      backgroundColor: '#546768',
    },
    PushNotifications: {
      presentationOptions: ['badge', 'sound', 'alert'],
    },
    SplashScreen: {
      launchShowDuration: 3000,
      launchAutoHide: true,
      // launchFadeOutDuration: 3000,
      backgroundColor: '#546768',
      androidSplashResourceName: 'splash',
      androidScaleType: 'CENTER_CROP',
      showSpinner: true,
      androidSpinnerStyle: 'large',
      iosSpinnerStyle: 'small',
      spinnerColor: '#e4d7b5',
      splashFullScreen: true,
      splashImmersive: true,
      layoutName: 'launch_screen',
      useDialog: true,
    },
    StatusBar: {
      overlaysWebView: true,
      style: 'dark',
      backgroundColor: '#546768',
    },
  },
  android: {
    buildOptions: {
      keystorePath:
        '/Users/zagham/Developer/Alaziz Software Solutions/Fiverr/Tenjump/BrickStory/jks/brickstory-keystore',
      keystoreAlias: 'brickstory',
    },
  },
};

export default config;
