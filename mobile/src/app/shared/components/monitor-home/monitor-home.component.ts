import { Component, inject, Input, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Listing } from 'src/app/core/services/api/models/api-response.model';

@Component({
  selector: 'app-monitor-home',
  templateUrl: './monitor-home.component.html',
  styleUrls: ['./monitor-home.component.scss'],
})
export class MonitorHomeComponent implements OnInit {
  @Input() public listing!: Listing;
  public monitorPhone: string = '';
  public phoneError: string = '';
  public isFormSubmitted: boolean = false;
  public modalCtrl = inject(ModalController);
  private api = inject(ApiService);
  public constructor(private alert: AlertService) {}

  public ngOnInit(): void {}
  public monitorHome(): void {
    this.isFormSubmitted = true;
    this.phoneError = '';

    // Validate phone number
    if (!this.monitorPhone || this.monitorPhone.trim() === '') {
      this.phoneError = 'Phone number must be 10 digits.';
      return;
    }

    // Basic phone number format validation (at least 10 digits)
    const phoneDigits = this.monitorPhone.replace(/\D/g, '');
    if (phoneDigits.length < 10) {
      this.phoneError = 'Phone number must be 10 digits.';
      return;
    }
    this.api
      .monitorHome(
        JSON.stringify({
          property_id: +this.listing.id,
          monitorPhone: this.monitorPhone,
        })
      )
      .subscribe((res: any) => {
        if (res.status == 'success') {
          this.alert.presentAlert(
            'Success',
            '',
            'Now Home is being monitored',
            [
              {
                text: 'OK',
                role: 'confirm',
                handler: () => {
                  this.modalCtrl.dismiss(null, 'success');
                },
              },
            ]
          );
        } else {
          this.alert.presentAlert(
            'Failed',
            '',
            'Failed to monitor home',
            [
              {
                text: 'OK',
                role: 'cancel',
                handler: () => {
                  this.modalCtrl.dismiss(null, 'fail');
                },
              },
            ]
          );
        }
      });
  }
}
