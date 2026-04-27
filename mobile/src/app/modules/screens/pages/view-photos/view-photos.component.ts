import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AlertController, ModalController } from '@ionic/angular';
import { AddPeopleComponent } from 'src/app/shared/components/add-people/add-people.component';
import { AddStoryComponent } from 'src/app/shared/components/add-story/add-story.component';
import { LivedModelComponent } from 'src/app/shared/components/lived-model/lived-model.component';
import { environment } from 'src/environments/environment';
import { UpdateStoriesComponent } from '../update-stories/update-stories.component';
import { ApiService } from 'src/app/core/services/api/http.service';
import { IStory } from 'src/app/shared/models/photo-story.model';
import { PhotoPreviewComponent } from 'src/app/shared/components/photo-preview/photo-preview.component';

@Component({
  selector: 'app-view-photos',
  templateUrl: './view-photos.component.html',
  styleUrls: ['./view-photos.component.scss'],
})
export class ViewPhotosComponent implements OnInit {
  public viewPhtotAndStories!: IStory;
  public isLogin: any;
  public states: any;
  public allstates: any;
  public imageUrl: string = environment.imageUrl;
  public defaultImage: string = 'assets/img/story.png';
  public imageSrc!: string;
  public description: string = '';
  public isImageLoading: boolean = true;
  public constructor(
    public router: Router,
    private modalCtrl: ModalController,
    public dataService: ApiService,
    private alertController: AlertController
  ) {}

  public ngOnInit() {
    this.getParams();
    const user = localStorage.getItem('userData');
    if (user) {
      this.isLogin = JSON.parse(user).id;
    }
    this.viewPhtotAndStories = history.state.homeDetails;
    console.log(this.viewPhtotAndStories);
    this.isImageLoading = true;
    this.checkImage(this.viewPhtotAndStories.story_photo).then((isValid) => {
      this.imageSrc = isValid
        ? this.viewPhtotAndStories.story_photo
        : this.defaultImage;
      this.isImageLoading = false;
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

  public openMap(event: any, listing: IStory): void {
    event.stopPropagation();
    window.open(`https://maps.google.com/?q= ${listing.city},${listing.state}`);
  }

  public async livedHere() {
    const result = localStorage.getItem('userData');
    if (result == null) {
      this.router.navigate(['/auth/intro']);
    } else {
      const modal = await this.modalCtrl.create({
        component: LivedModelComponent,
        componentProps: {
          data: this.viewPhtotAndStories,
        },
      });
      modal.present();
    }
  }
  public async people() {
    const result = localStorage.getItem('userData');
    if (result == null) {
      this.router.navigate(['/auth/intro']);
    } else {
      const modal = await this.modalCtrl.create({
        component: AddPeopleComponent,
        componentProps: {
          data: this.viewPhtotAndStories.master_story_id,
        },
      });
      modal.present();
    }
  }
  public async addstory() {
    const result = localStorage.getItem('userData');
    if (result == null) {
      this.router.navigate(['/auth/intro']);
    } else {
      const modal = await this.modalCtrl.create({
        component: AddStoryComponent,
        componentProps: {
          data: this.viewPhtotAndStories.master_story_id,
        },
      });
      modal.present();
    }
  }

  public async editPhotosAndStories(viewPhtotAndStories: any): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: UpdateStoriesComponent,
      componentProps: {
        data: viewPhtotAndStories,
      },
    });
    modal.present();
  }

  public getParams(): void {
    this.dataService.homeParams().subscribe(
      (data) => {
        this.allstates = data.data.states;
        if (typeof this.allstates === 'object' && this.allstates !== null) {
          const allStatesArray = Object.entries(this.allstates).map(
            ([key, value]) => ({ key, value })
          );
          const foundState = allStatesArray.find(
            (item) => item.key === this.viewPhtotAndStories.state
          );
          if (foundState) {
            this.states = foundState.value;
          } else {
          }
        } else {
          console.error('Expected an object but got:', this.allstates);
        }
      },
      (error) => {
        console.error('Error fetching params:', error);
      }
    );
  }
  public async previewImage(src: string, event: any): Promise<void> {
    event.stopPropagation();
    const modal = await this.modalCtrl.create({
      component: PhotoPreviewComponent,
      componentProps: {
        photo: src,
      },
    });
    modal.present();
  }
  public async iAgreeToReport(): Promise<void> {
    const userFound = localStorage.getItem('userData');
    if (userFound == null) {
      this.router.navigate(['/auth/intro']);
    } else {
      const alert = await this.alertController.create({
        header: 'Flag Inappropriate Entry',
        message: `“By clicking “OK” you agree to notify BrickStory that this post is inappropriate”`,
        mode: 'ios',
        buttons: [
          {
            text: 'Cancel',
            role: 'cancel',
            cssClass: 'secondary',
            handler: () => {
              console.log('Report cancelled');
            },
          },
          {
            text: 'OK',
            cssClass: 'alert-button-flag',
            handler: () => {
              this.chooseOption();
            },
          },
        ],
      });
      await alert.present();
    }
  }
  public async chooseOption(): Promise<void> {
    const result = localStorage.getItem('userData');
    if (result == null) {
      this.router.navigate(['/auth/intro']);
    } else if (result) {
      const alert = await this.alertController.create({
        header: 'Flag Inappropriate Entry?',
        message: `Inappropriate or Possible Trademark issues`,
        mode: 'ios',
        buttons: [
          {
            text: 'Inappropriate',
            cssClass: 'alert-button-flag',
            role: 'confirm',
            handler: () => {
              this.flagStory('Flag Inappropriate Entry?');
            },
          },
          {
            text: 'Possible Trademark',
            cssClass: 'alert-button-flag',
            role: 'confirm',
            handler: () => {
              this.flagStory('Possible Trademark issues?');
            },
          },
        ],
      });
      await alert.present();
    }
  }
  public async flagStory(
    header: 'Flag Inappropriate Entry?' | 'Possible Trademark issues?'
  ): Promise<void> {
    const alert = await this.alertController.create({
      header: header,
      mode: 'ios',
      inputs: [
        {
          name: 'description',
          label: 'Description',
          type: 'textarea',
          placeholder: 'Enter the description for reporting',
        },
      ],
      buttons: [
        {
          text: 'Cancel',
          role: 'cancel',
          cssClass: 'secondary',
          handler: () => {
            console.log('Report cancelled');
          },
        },
        {
          text: 'Send notice',
          cssClass: 'alert-button-flag',
          role: 'confirm',
          handler: (input) => {
            console.log('Report submitted', input);
            const formData = new FormData();
            formData.append('entry_id', this.viewPhtotAndStories.id.toString());
            formData.append(
              'flag_type',
              header === 'Flag Inappropriate Entry?'
                ? 'inappropriate'
                : 'trademark'
            );
            formData.append('description', input.description);

            this.dataService.submitTrademark(formData).subscribe(
              async (response) => {
                console.log('Story reported successfully', response);
                // Show success alert with server message if available
                const serverMessage =
                  response && response.message
                    ? response.message
                    : 'Report submitted successfully.';
                const successAlert = await this.alertController.create({
                  header: 'Report Sent',
                  message: serverMessage,
                  buttons: ['OK'],
                  mode: 'ios',
                });
                await successAlert.present();
              },
              async (error) => {
                console.error('Error reporting story', error);
                const errMsg =
                  error && error.error && error.error.message
                    ? error.error.message
                    : 'Failed to submit report. Please try again later.';
                const errorAlert = await this.alertController.create({
                  header: 'Report Failed',
                  message: errMsg,
                  buttons: ['OK'],
                  mode: 'ios',
                });
                await errorAlert.present();
              }
            );
          },
        },
      ],
    });
    await alert.present();
  }
}
