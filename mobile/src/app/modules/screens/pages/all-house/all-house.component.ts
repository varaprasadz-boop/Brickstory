import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Listing, ParamsData } from 'src/app/core/services/api/models/api-response.model';
import { FilterModalComponent } from 'src/app/shared/components/filter-modal/filter-modal.component';

@Component({
  selector: 'app-all-house',
  templateUrl: './all-house.component.html',
  styleUrls: ['./all-house.component.scss'],
})
export class AllHouseComponent  implements OnInit {
    public allHouses:Listing[]=[];
    private params!: ParamsData;
    public currentPage:number = 1;
    public isFiltered: boolean = false;
    private filteredParams: any;
    public isLoading = false;
    public hasMoreData = true;
    constructor(public dataService:ApiService, private modalCtrl: ModalController,  private cdr: ChangeDetectorRef) {}

  public ngOnInit():void {
    this.allHousesByProperties(this.currentPage);
  }


  public allHousesByProperties(page: number): void {
    if (this.isLoading) {
      return;
    }
    this.isLoading = true;
    const urlParam:any = this.buildUrlParam(page);
    this.dataService.allHousesby(urlParam).subscribe(
      (res) => {
        this.allHouses = res.data.properties? [
          ...this.allHouses,
          ...res.data.properties
        ] : [];
        if (res.data.properties.length === 0) {
          this.hasMoreData = false;
        }
        this.isLoading = false;
        const infiniteScroll = document.querySelector('ion-infinite-scroll');
         if (infiniteScroll) {
          (infiniteScroll as any).complete();
          if (!this.hasMoreData) {
            (infiniteScroll as any).disabled = true;
          }
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

  public loadMore(event: any): void {
    if (!this.hasMoreData) {
      event.target.complete();
      event.target.disabled = true;
      return;
    }
    
    if (this.isLoading) {
      event.target.complete();
      return;
    }
    
    this.currentPage++;
    this.allHousesByProperties(this.currentPage);
  }
  public async getParams(): Promise<void> {
    try {
      const params: any = await this.dataService.homeParams().toPromise();
      this.params = params.data;
    } catch (error) {
      console.error('Error fetching params:', error);
    }
  }
  public async clearFilter(): Promise<void> {
    this.isFiltered = false;
    try {
      this.currentPage = 1;
      this.allHouses = [];
      this.hasMoreData = true;
      
      // Re-enable infinite scroll
      const infiniteScroll = document.querySelector('ion-infinite-scroll');
      if (infiniteScroll) {
        (infiniteScroll as any).disabled = false;
      }
      
      this.allHousesByProperties(this.currentPage);
      this.cdr.detectChanges();
    } catch (error) {
      console.error('Error getting coordinates:', error);
    }
  }
  public async openFilterModal(): Promise<void> {
    try {
      await this.getParams();
      const modal = await this.modalCtrl.create({
        component: FilterModalComponent,
        componentProps: {
          params: this.params,
          type:'houses'
        },
      });
      await modal.present();
      const { data, role } = await modal.onWillDismiss();
      if (role === 'confirm') {
        this.filteredParams = data;
        this.allHouses = [];
        this.currentPage = 1;
        this.isFiltered = true;
        this.hasMoreData = true;
        
        // Re-enable infinite scroll
        const infiniteScroll = document.querySelector('ion-infinite-scroll');
        if (infiniteScroll) {
          (infiniteScroll as any).disabled = false;
        }
        
        this.allHousesByProperties(this.currentPage);
      }
    } catch (error) {
      console.error('Error opening filter modal:', error);
    }
  }

  private buildUrlParam(page: number): string {
    return !this.isFiltered
      ? `houses/${page}?`
      : `houses/${page}?house_style_id=${this.filteredParams.houseStyle}&state=${this.filteredParams.state}&bedroom_id=${this.filteredParams.bedroom}&material_id=${this.filteredParams.material}&foundation_id=${this.filteredParams.foundation}&roof_id=${this.filteredParams.roofType}&city=${this.filteredParams.city}&country=${this.filteredParams.country}&zip=${this.filteredParams.zipCode}&owner_name=${this.filteredParams.ownerName}&nrhp=${this.filteredParams.nrhp ? true : ''}&minRangeSquareFeet=${this.filteredParams.rangeSquareFeet.lower}&maxRangeSquareFeet=${this.filteredParams.rangeSquareFeet.upper == 10000 ? this.filteredParams.rangeSquareFeet.upper+'+':this.filteredParams.rangeSquareFeet.upper }&minRangeYearBuilt=${this.filteredParams.rangeYearBuilt.lower}&maxRangeYearBuilt=${this.filteredParams.rangeYearBuilt.upper}&street=${this.filteredParams.street}`;
  }

}
