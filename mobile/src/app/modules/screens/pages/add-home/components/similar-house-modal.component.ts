import { Component, Input } from '@angular/core';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-similar-house-modal',
  templateUrl: './similar-house-modal.component.html',
  styleUrls: ['./similar-house-modal.component.scss'],
})
export class SimilarHouseModalComponent {
  @Input() similarHouse: any;
  @Input() currentFormData: any;

  constructor(private modalCtrl: ModalController) {}

  dismiss() {
    this.modalCtrl.dismiss();
  }

  selectExistingHome() {
    // Return data indicating user selected existing home
    this.modalCtrl.dismiss({
      action: 'existing',
      similarHouse: this.similarHouse,
      currentFormData: this.currentFormData
    });
  }

  selectNewHome() {
    // Return data indicating user wants to create new home
    this.modalCtrl.dismiss({
      action: 'new',
      currentFormData: this.currentFormData
    });
  }
}