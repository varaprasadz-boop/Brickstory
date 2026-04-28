import { Component, OnInit, ViewChild } from '@angular/core';
import { IonRouterOutlet, Platform } from '@ionic/angular';
import { SplashScreen } from '@capacitor/splash-screen';
import { EdgeToEdge } from '@capawesome/capacitor-android-edge-to-edge-support';
import { StatusBar, Style } from '@capacitor/status-bar';

// 👇 Import the NavigationBar plugin
import { NavigationBar } from '@capgo/capacitor-navigation-bar';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent implements OnInit {
  @ViewChild(IonRouterOutlet, { static: true })
  private routerOutlet!: IonRouterOutlet;

  public constructor(private platform: Platform) {
    this.initializeApp();
    this.backButtonHandler();
  }

  public ngOnInit(): void {}

  private async initializeApp(): Promise<void> {
    await this.platform.ready();

    await this.setStatusBar();
    await this.setNavigationBar(); // 👈 Set nav bar style
    await SplashScreen.hide();
  }

  private async setStatusBar(): Promise<void> {
    await EdgeToEdge.enable();
    await EdgeToEdge.setBackgroundColor({ color: '#546768' });
    await StatusBar.setStyle({ style: Style.Dark });
    await StatusBar.setBackgroundColor({ color: '#546768' });
  }

  // 👇 Add this function
  private async setNavigationBar(): Promise<void> {
    try {
      await NavigationBar.setNavigationBarColor({
        color: '#546768',
        darkButtons: false,
      });
    } catch (error) {
      console.error('NavigationBar error', error);
    }
  }

  private async backButtonHandler(): Promise<void> {
    this.platform.backButton.subscribeWithPriority(10, () => {
      if (!this.routerOutlet.canGoBack()) {
        // App.exitApp();
      } else {
        this.routerOutlet.pop();
      }
    });
  }
}
