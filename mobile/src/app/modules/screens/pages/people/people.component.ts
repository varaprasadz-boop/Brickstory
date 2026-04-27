import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/core/services/api/http.service';
import { People } from 'src/app/shared/models/people.model';
import { Router } from '@angular/router';
import { FilterPeople } from 'src/app/shared/models/filterpeople.model';
import { ModalController } from '@ionic/angular';
import { FilterPeopleComponent } from 'src/app/shared/components/filter-people/filter-people.component';
import { PhotoPreviewComponent } from 'src/app/shared/components/photo-preview/photo-preview.component';
@Component({
  selector: 'app-people',
  templateUrl: './people.component.html',
  styleUrls: ['./people.component.scss'],
})
export class PeopleComponent implements OnInit {
  public people: People[] = []; 
  public filterArray: any = []
  public isFilter: boolean = false;
  private currentPage = 1;
  private isLoading = false;
  public isDataComplete: boolean = false;
  public constructor(public dataService: ApiService, private router: Router,private modalCtrl: ModalController) {}

  public ngOnInit() {
  this.getPeople(this.currentPage);
  }

  public homeDetails(id: string, pid:any): void {
    this.router.navigate(['/screens/view-detail', id, 'people',pid]);
  }

  public getPeople(page: number): void {
    if (this.isLoading || this.isDataComplete) {
      return;
    }
    this.isLoading = true;
    const urlParam:any = this.buildUrlParam(page);
    this.dataService.peoplesby(urlParam).subscribe(
      (response: any) => {
        if (response.data.peoples.length === 0) {
          this.isDataComplete = true;
        } else {
          this.people = [...this.people, ...response.data.peoples];
          console.log(this.people); 
        }
        this.isLoading = false;
        const infiniteScroll = document.querySelector('ion-infinite-scroll');
        if (infiniteScroll) {
          (infiniteScroll as any).complete();
        }
      },
      (error) => {
        console.error('Error loading data', error);
        this.isLoading = false;
        const infiniteScroll = document.querySelector('ion-infinite-scroll');
        if (infiniteScroll) {
          (infiniteScroll as any).complete();
        }
      }
    );
  }
  
  public loadMorePeople(event: any): void {
    if (this.isDataComplete) {
      event.target.complete();
      return;
    }
    const nextPage = this.currentPage + 1;  
    this.getPeople(this.currentPage);
    this.currentPage = nextPage; 
  }

  public async filterPhotoAndshoties(): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: FilterPeopleComponent,
    });
    modal.present();
    const { data, role } = await modal.onDidDismiss();
    if (role=='confirm') {
      this.filterArray = data; 
      this.people = [];
      this.isFilter = true;
      this.currentPage = 1;
      this.getPeople(this.currentPage);
    }
  }
  private buildUrlParam(page: number): string { 
    return !this.isFilter
      ? `peoples/${page}?`
      : `peoples/${page}?first_name=${this.filterArray.first_name}&last_name=${this.filterArray.last_name}&relation_id=${this.filterArray.relation}${this.filterArray.nrhp == 1 ? `&nrhp=on` : ''}`;
  }

  private completeInfiniteScroll(): void {
    const infiniteScroll = document.querySelector('ion-infinite-scroll');
    if (infiniteScroll) {
      (infiniteScroll as any).complete();
    }
  }
  public clearFilter() {
    this.isFilter = false;
    this.currentPage = 1;
    this.people = [];
    this.getPeople(this.currentPage);
  }

  public async goToPeopleImage(person_photo:any, event:Event){
    event.stopPropagation();
    const modal = await this.modalCtrl.create({
      component: PhotoPreviewComponent,
      componentProps:{
      photo:person_photo,
      }
    });
    modal.present();
  }
 
}
