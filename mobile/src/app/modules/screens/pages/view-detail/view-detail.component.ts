import {
  AfterViewInit,
  Component,
  ElementRef,
  OnInit,
  QueryList,
  ViewChild,
  ViewChildren,
} from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { IonAccordionGroup, IonContent, ViewDidEnter } from '@ionic/angular';
import { AlertController, ModalController } from '@ionic/angular';
import {
  Listing,
  PropertyDetails,
} from 'src/app/core/services/api/models/api-response.model';
import { StoriesModalComponent } from 'src/app/modules/tabs/shared/components/stories-modal/stories-modal.component';
import { AddPeopleComponent } from 'src/app/shared/components/add-people/add-people.component';
import { AddStoryComponent } from 'src/app/shared/components/add-story/add-story.component';
import { LivedModelComponent } from 'src/app/shared/components/lived-model/lived-model.component';
import { environment } from 'src/environments/environment';
import { UpdateHomeComponent } from '../update-home/update-home.component';
import { photosAndHistory } from 'src/app/core/services/api/models/api-payload.model';
import { ApiService } from 'src/app/core/services/api/http.service';
import { TimelineEvent } from 'src/app/shared/models/timeline.model';
import { PhotoPreviewComponent } from 'src/app/shared/components/photo-preview/photo-preview.component';
import { PropertyDetailsResolver } from 'src/app/core/resolvers/property-details.resolver';
import { LoadingService } from 'src/app/core/services/loading/loading.service';

@Component({
  selector: 'app-view-detail',
  templateUrl: './view-detail.component.html',
  styleUrls: ['./view-detail.component.scss'],
})
export class ViewDetailComponent
  implements OnInit, ViewDidEnter, AfterViewInit
{
  @ViewChildren('timelineElement') timelineElements!: QueryList<ElementRef>;
  public isLogin: any;
  public states: any;
  public myTimeLine: TimelineEvent[] = [];
  public listing!: PropertyDetails;
  public selectedSegment: string = 'details';
  public imageUrl: string = environment.imageUrl;
  public defaultImage: string = '../../../../../assets/img/story.png';
  public backgroundStyle: string = '../../../../assets/img/story.png';
  public imageSrc!: string;
  public homeParams: any;
  public allstates: any;
  private peopleID: any;
  public isTimelineLoading = false;
  
  public constructor(
    private modalCtrl: ModalController,
    private router: Router,
    private route: ActivatedRoute,
    public dataService: ApiService,
    public alertController: AlertController,
    private resolver: PropertyDetailsResolver,
    private loadingService: LoadingService
  ) {}
  public ionViewDidEnter(): void {
    this.toggleAccordion(this.peopleID);
  }

  public toggleAccordion = (pid: any) => {
    const nativeEl = document.getElementById('accordionGroup');
    nativeEl?.setAttribute('value', pid);
    nativeEl?.scrollIntoView({ behavior: 'smooth' });
  };

  public ngOnInit(): void {
    this.route.params.subscribe((res: any) => {
      this.selectedSegment = res.segment;
      console.log(res);
      if (res.segment == 'people') {
        this.peopleID = res.pid;
      }
      if (res.segment == 'timeline') {
        this.peopleID = res.pid;
      }
    });
    this.getParams();
    this.route.data.subscribe((res: any) => {
      this.listing = res.homeDetails;
      console.log(this.listing);
    });
    const user: any = localStorage.getItem('userData');
    if (user) {
      this.isLogin = JSON.parse(user).id;
    }
    this.homeDetailsTimeline();
  }
  public ngAfterViewInit(): void {
    setTimeout(() => {
      this.scrollToElement(this.peopleID);
    }, 2000); // Use timeout to give the DOM time to render
  }

  public scrollToElement(id: string): void {
    const element = this.timelineElements.find(
      (el) => el.nativeElement.id === id
    );
    if (element) {
      element.nativeElement.scrollIntoView({ behavior: 'smooth' });
    } else {
      console.log('Element with ID', id, 'not found');
    }
  }

  public checkImage(url: string): Promise<boolean> {
    return new Promise((resolve) => {
      const img = new Image();
      img.onload = () => resolve(true);
      img.onerror = () => resolve(false);
      img.src = url;
    });
  }

  public gotoStoriesDetail(item: any): void {
    if (this.listing.sub_stories.length > 0) {
      const findIndex = this.listing.sub_stories.findIndex(
        (x: any) => x.id === item.id
      );
      if (findIndex > -1) {
        const story = this.listing.sub_stories[findIndex];
        this.router.navigate(['/screens/view-photos'], {
          state: { homeDetails: story },
        });
      }
    }
  }
  public homeDetailsTimeline(): void {
    this.isTimelineLoading = true;
    this.dataService
      .homeDetailTimeline(this.listing.home.id, this.listing.home.user_id)
      .subscribe(
        (res: any) => {
          const myTimelineData = res.data;
          const mappedTimeline = myTimelineData.timeline.map((item: any) => ({
            person_photo: item.person_photo,
            first_name: item.frist_name,
            last_name: item.last_name,
            from_date: item.from_date,
            indicator: item.Indicator,
            living: item.living,
            to_date: item.to_date,
          }));
          const mappedSubTimeline = myTimelineData.sub_timeline.map(
            (item: any) => ({
              id: item.id,
              story_photo: item.story_photo,
              first_name: item.firstname,
              last_name: item.lastname,
              from_date: item.approximate_date,
              description: item.story_description,
              setting: item.setting,
              season: item.season,
              event: item.event,
              side_of_house: item.side_of_house,
              room: item.room,
              user_id: item.user_id,
            })
          );
          const combinedTimeline = [...mappedTimeline, ...mappedSubTimeline];
          combinedTimeline.sort((a, b) => {
            const dateA = new Date(a.from_date).getTime();
            const dateB = new Date(b.from_date).getTime();
            return dateA - dateB;
          });
          this.myTimeLine = combinedTimeline;
          this.isTimelineLoading = false;
          console.log(this.myTimeLine);
        },
        (error) => {
          console.error('Error loading timeline:', error);
          this.isTimelineLoading = false;
        }
      );
  }

  public async livedHere() {
    const result = localStorage.getItem('userData');
    if (result == null) {
      this.router.navigate(['/auth/intro']);
    } else {
      const modal = await this.modalCtrl.create({
        component: LivedModelComponent,
        componentProps: {
          data: this.listing.home,
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
          data: this.listing.home.id,
        },
      });
      await modal.present();

      const { role } = await modal.onWillDismiss();
      if (role !== 'cancel') {
        this.refreshViewDetail(this.listing.home.id);
      }
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
          data: this.listing.home.id,
        },
      });
      await modal.present();

      const { role } = await modal.onWillDismiss();
      if (role !== 'cancel') {
        this.refreshViewDetail(this.listing.home.id);
      }
    }
  }

  public async openStoriesModal(): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: StoriesModalComponent,
      initialBreakpoint: 0.05,
      breakpoints: [0.94],
    });
    modal.present();
    const content: any = document.querySelector('#ionContent');
    content.appendChild(modal);
  }

  public openMap(event: any, listing: PropertyDetails): void {
    event.stopPropagation();
    window.open(
      `https://maps.google.com/?q=${listing.home.address1},${listing.home.address2},${listing.home.city},${this.states},${listing.home.zip}`
    );
  }

  async locationAlert() {
    const alert = await this.alertController.create({
      header: 'No Location Found!',
      buttons: [
        {
          text: 'Okay',
          handler: () => {
            console.log('Confirm Okay');
          },
        },
      ],
    });

    await alert.present();
  }

  public getParams(): void {
    this.dataService.homeParams().subscribe(
      (data) => {
        this.homeParams = data.data;
        this.allstates = data.data.states;
        if (typeof this.allstates === 'object' && this.allstates !== null) {
          const allStatesArray = Object.entries(this.allstates).map(
            ([key, value]) => ({ key, value })
          );
          const foundState = allStatesArray.find(
            (item) => item.key === this.listing.home.state
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

  public async editHome(): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: UpdateHomeComponent,
      componentProps: {
        homeDetails: this.listing.home,
        params: this.homeParams,
      },
    });
    await modal.present();

    const { role } = await modal.onWillDismiss();
    if (role !== 'cancel') {
      this.refreshViewDetail(this.listing.home.id);
    }
  }
  public onSegmentChange(event: any) {
    this.selectedSegment = event.detail.value;
  }
  public refreshViewDetail(id: string): void {
    this.loadingService.showLoading(5000);
    this.resolver.resolve(this.route.snapshot, {} as any).subscribe({
      next: (res) => {
        this.listing = res;
        this.homeDetailsTimeline(); // reload timeline
        this.getParams(); // reload states
        this.loadingService.loadingCtrl.dismiss();
      },
      error: (error) => {
        console.error('Error refreshing view detail:', error);
        this.loadingService.loadingCtrl.dismiss();
      }
    });
  }

  public async goToPeopleImageProfile(item: any, event: Event) {
    event.stopPropagation();
    const modal = await this.modalCtrl.create({
      component: PhotoPreviewComponent,
      initialBreakpoint: 0.98,
      componentProps: {
        photo: item.person_photo,
      },
    });
    modal.present();
  }

  public async goToPeopleImage(item: any, event: Event) {
    event.stopPropagation();
    const modal = await this.modalCtrl.create({
      component: PhotoPreviewComponent,
      initialBreakpoint: 0.98,
      componentProps: {
        photo: item.indicator ? item.person_photo : item.story_photo,
      },
    });
    modal.present();
  }
  public async goToStoryImage(item: any, event: Event) {
    event.stopPropagation();
    const modal = await this.modalCtrl.create({
      component: PhotoPreviewComponent,
      initialBreakpoint: 0.98,
      componentProps: {
        photo: item,
      },
    });
    modal.present();
  }
}
