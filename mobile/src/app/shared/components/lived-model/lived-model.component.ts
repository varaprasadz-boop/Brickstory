import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { ModalController, NavParams } from '@ionic/angular';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';

@Component({
  selector: 'app-lived-model',
  templateUrl: './lived-model.component.html',
  styleUrls: ['./lived-model.component.scss'],
})
export class LivedModelComponent implements OnInit {
  public livedHere: any = {
    user_id: '',
    property_id: '',
    from_date: '',
    to_date: '',
    from_date_raw: '',
    to_date_raw: '',
    user_lived_here: 0,
  };

  constructor(
    private modalCtrl: ModalController,
    private navParams: NavParams,
    private date: DatePipe,
    private dataService: ApiService,
    private alert: AlertService
  ) {
    const data = this.navParams.get('data');
    this.livedHere.property_id = data.id;

    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.livedHere.user_id = user.id;
  }

  ngOnInit(): void {}

  cancel() {
    return this.modalCtrl.dismiss(null, 'cancel');
  }

  confirm() {
    return this.modalCtrl.dismiss('confirm');
  }

  onDateChange(event: any, type: string): void {
    const rawValue = event.target.value;

    if (type === 'from') {
      this.livedHere.from_date_raw = rawValue;
      this.livedHere.from_date = this.date.transform(rawValue, 'MM/dd/yyyy');
    }

    if (type === 'to') {
      this.livedHere.to_date_raw = rawValue;
      this.livedHere.to_date = this.date.transform(rawValue, 'MM/dd/yyyy');
    }
  }

  onCheckboxChange(): void {
    if (this.livedHere.user_lived_here) {
      this.livedHere.to_date = '';
      this.livedHere.to_date_raw = '';
    }
  }

  submit() {
    // Validation
    if (!this.livedHere.from_date_raw) {
      this.alert.presentAlert('Missing Date', '', 'Please select a start date.', [
        { text: 'OK', role: 'cancel' },
      ]);
      return;
    }

    if (!this.livedHere.user_lived_here && !this.livedHere.to_date_raw) {
      this.alert.presentAlert('Missing Date', '', 'Please select an end date.', [
        { text: 'OK', role: 'cancel' },
      ]);
      return;
    }

    // Ensure end_date >= start_date if end date exists
    if (this.livedHere.to_date_raw) {
      const from = new Date(this.livedHere.from_date_raw);
      const to = new Date(this.livedHere.to_date_raw);
      if (to < from) {
        this.alert.presentAlert(
          'Invalid Dates',
          '',
          'End date cannot be earlier than start date.',
          [{ text: 'OK', role: 'cancel' }]
        );
        return;
      }
    }

    const livedHerePayload = JSON.stringify(this.livedHere);

    this.dataService.livedHere(livedHerePayload).subscribe((data) => {
      if (data.status === 'success') {
        this.alert.presentAlert(
          'Success',
          '',
          'Your lived here status has been updated successfully',
          [
            {
              text: 'OK',
              handler: () => {
                this.modalCtrl.dismiss('confirm');
              },
            },
          ]
        );
      } else {
        this.alert.presentAlert(
          'Failed',
          '',
          'Failed to update your lived here status',
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
