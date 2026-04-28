import { Injectable } from '@angular/core';
import { LoadingController } from '@ionic/angular';

@Injectable({
  providedIn: 'root'
})
export class LoadingService {

  public constructor(public loadingCtrl: LoadingController) { }
  public async showLoading(duration:number) :Promise<void> {
    const loading = await this.loadingCtrl.create({
      message: 'Please wait...',
      spinner:'lines',
      duration: duration,
      mode:'ios'
    });

    loading.present();
  }
}
