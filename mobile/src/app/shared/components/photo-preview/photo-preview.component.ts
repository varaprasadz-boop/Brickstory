import { Component, Input, input, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
@Component({
  selector: 'app-photo-preview',
  templateUrl: './photo-preview.component.html',
  styleUrls: ['./photo-preview.component.scss'],
})
export class PhotoPreviewComponent implements OnInit {
  @Input() public photo: any;
  public safePhoto: string = '';
  public hideImage: boolean = false;

  private defaultImage = 'assets/img/no-image.png'; // ✅ Update path if needed

  constructor(private modalCtrl: ModalController) {}

  ngOnInit() {
    if (
      !this.photo ||
      typeof this.photo !== 'string' ||
      this.photo.trim() === ''
    ) {
      this.hideImage = true; // Don’t show anything
    } else {
      this.safePhoto = this.photo;
    }
  }

  public handleImageError() {
    // Called when image fails to load
    this.safePhoto = this.defaultImage;
  }

  public cancel() {
    this.modalCtrl.dismiss('cancel');
  }
}
