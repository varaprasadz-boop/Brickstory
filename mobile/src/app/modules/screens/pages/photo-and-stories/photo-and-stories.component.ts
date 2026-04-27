import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/core/services/api/http.service';
import { photosAndHistory } from 'src/app/core/services/api/models/api-payload.model';
import { ModalController } from '@ionic/angular';
import { FilterphotosComponent } from 'src/app/shared/components/filterphotos/filterphotos.component';
import { ParamsData } from 'src/app/core/services/api/models/api-response.model';

@Component({
  selector: 'app-photo-and-stories',
  templateUrl: './photo-and-stories.component.html',
  styleUrls: ['./photo-and-stories.component.scss'],
})
export class PhotoAndStoriesComponent implements OnInit {
  public photosAndStories: photosAndHistory[] = [];
  private currentPage = 1;
  private isLoading = false;
  public filteredParams: any;
  public isFiltered: boolean = false;
  private params!:ParamsData;
  public constructor(
    public dataService: ApiService,
    private modalCtrl: ModalController
  ) {}

  public ngOnInit(): void {
    this.getphotosAndStories(this.currentPage);
  }

  public getphotosAndStories(page: number): void {
    if (this.isLoading) {
      return;
    }
    this.isLoading = true;
    const urlParam = this.buildUrlParam(page);
    this.dataService.photosAndHistory(urlParam).subscribe(
      (data) => {
        console.log(data.data.result);
        this.photosAndStories = [...this.photosAndStories, ...data.data.result];
        this.isLoading = false;
        this.completeInfiniteScroll();
      },
      (error) => {
        console.error('Error loading data', error);
        this.isLoading = false;
        this.completeInfiniteScroll();
      }
    );
  }

  public loadMore(event: any): void {
    if (this.isLoading) {
        event.target.complete();
        return;
    } 
    const nextPage = this.currentPage + 1; 
    this.getphotosAndStories(nextPage);
    this.currentPage = nextPage;
}



  public async getParams(): Promise<void> {
    try {
      const params: any = await this.dataService.homeParams().toPromise();
      this.params = params.data; 
    } catch (error) {
      console.error('Error fetching params:', error);
    }
  }

  public async filterPhotoAndStories(): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: FilterphotosComponent,
    });
    await modal.present();
    const { data, role } = await modal.onWillDismiss();
    if (role === 'confirm') {
      this.filteredParams = data;
      this.photosAndStories = [];
      this.currentPage = 1;
      this.isFiltered = true;
      this.getphotosAndStories(this.currentPage);
    }
  }

  private buildUrlParam(page: number): string {
    return !this.isFiltered
      ? `photosnhistory/${page}?`
      : `photosnhistory/${page}?setting_id=${this.filteredParams.setting}&season_id=${this.filteredParams.season}&event_id=${this.filteredParams.events}&side_of_house_id=${this.filteredParams.houseSide}${this.filteredParams.nrhp == 1 ? `&nrhp=on` : ''}`;
  }

  private completeInfiniteScroll(): void {
    const infiniteScroll = document.querySelector('ion-infinite-scroll');
    if (infiniteScroll) {
      (infiniteScroll as any).complete();
    }
  }
  public clearFilter() {
    this.isFiltered = false;
    this.currentPage = 1;
    this.photosAndStories = [];
    this.getphotosAndStories(this.currentPage);
  }
}
