import {
  Component,
  EventEmitter,
  Inject,
  inject,
  Input,
  OnInit,
  Output,
} from '@angular/core';
import { Router } from '@angular/router';
import { Listing } from 'src/app/core/services/api/models/api-response.model';
import { environment } from 'src/environments/environment';
import { ModalController } from '@ionic/angular';
import { MonitorHomeComponent } from '../monitor-home/monitor-home.component';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
@Component({
  selector: 'app-card',
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.scss'],
})
export class CardComponent implements OnInit {
  @Input() public listing!: Listing;
  @Input() type: string = '';
  @Output() public clicked: EventEmitter<boolean> = new EventEmitter<boolean>();
  public imageUrl: string = environment.imageUrl;
  public defaultImage = '../../../../assets/img/story.png';
  public backgroundStyle: string = '';
  public router: Router = inject(Router);
  private data: ApiService = inject(ApiService);
  private alert: AlertService = inject(AlertService);
  private modalController: ModalController = inject(ModalController);
  public constructor() {}

  public ngOnInit(): void {
    this.checkImage(this.listing.home_profile_photo).then((isValid: any) => {
      this.backgroundStyle = `url(${
        isValid ? this.listing.home_profile_photo : this.defaultImage
      })`;
    });
  }
  public checkImage(url: string): Promise<boolean> {
    return new Promise((resolve) => {
      const img = new Image();
      img.onload = () => resolve(true);
      img.onerror = () => resolve(false);
      img.src = url;
    });
  }
  public openMap(event: Event, listing: Listing): void {
    event.stopPropagation();
    window.open(
      `https://maps.google.com/?q=${listing.address1},${listing.address2},${listing.city},${listing.state},${listing.zip}`
    );
  }
  public homeDetails(): void {
    this.router.navigate([
      '/screens/view-detail',
      this.listing.id,
      'details',
      0,
    ]);
  }
  public async monitorMyHome(event: Event): Promise<void> {
    event.stopPropagation();
    if (this.listing.monitor_home == '0') {
      const modal = await this.modalController.create({
        component: MonitorHomeComponent,
        id: 'monitor-home-modal',
        backdropDismiss: false,
        componentProps: { listing: this.listing },
      });
      await modal.present();
      this.clicked.emit(true);
    } else {
      this.alert.presentAlert(
        'Stop Monitoring?',
        '',
        'Are you sure you want to stop monitoring this home?',
        [
          {
            text: 'Cancel',
            role: 'cancel',
            handler: () => {},
          },
          {
            text: 'Stop',
            role: 'stop',
            cssClass: 'alert-button-stop',
            handler: () => {
              this.data
                .stopMonitorHome(+this.listing.id)
                .subscribe((res: any) => {
                  if (res.status == 'success') {
                    this.modalController.dismiss(null, 'success');
                    this.clicked.emit(true);
                  } else {
                    this.alert.presentAlert(
                      'Failed',
                      '',
                      'Failed to stop monitoring home',
                      [
                        {
                          text: 'Ok',
                          handler: () => {
                            this.modalController.dismiss(null, 'fail');
                          },
                        },
                      ]
                    );
                  }
                });
            },
          },
        ]
      );
    }
  }
}
