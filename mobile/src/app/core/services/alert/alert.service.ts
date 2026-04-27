import { TitleCasePipe } from '@angular/common';
import { Injectable } from '@angular/core';
import { AlertController } from '@ionic/angular';

@Injectable({
  providedIn: 'root',
})
export class AlertService {
  public constructor(
    private alertController: AlertController,
    private titleCase: TitleCasePipe
  ) {}
  public async presentAlert(
    header: string,
    subHeader: string,
    message: string,
    buttons: string[] | any[]
  ): Promise<void> {
    const alert = await this.alertController.create({
      header: this.titleCase.transform(header),
      subHeader: this.titleCase.transform(subHeader),
      message: message.replace(/<\/?p>/g,''),
      backdropDismiss:false,
      buttons: buttons,
    });
    await alert.present();
  }
}
