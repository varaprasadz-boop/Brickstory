import { ChangeDetectorRef, Component, inject, OnInit } from '@angular/core';
import { ModalController, ViewDidEnter } from '@ionic/angular';
import { Geolocation } from '@capacitor/geolocation';

import { ApiService } from 'src/app/core/services/api/http.service';
import {
  DropdownParams,
  HomeListing,
  Listing,
  NearbyListing,
  ParamsData,
} from 'src/app/core/services/api/models/api-response.model';
import { FilterModalComponent } from 'src/app/shared/components/filter-modal/filter-modal.component';
import { NavigationEnd, Router, Event } from '@angular/router';
import { filter } from 'rxjs';

@Component({
  selector: 'app-location',
  templateUrl: './location.component.html',
  styleUrls: ['./location.component.scss'],
})
export class LocationComponent implements OnInit, ViewDidEnter {
  private params!: ParamsData;
  public url: any;
  public nearbyListings: Listing[] = [];
  public isFiltered: boolean = false;
  public currentPage = 1;
  public isLoading = false;
  private hasMoreData = true;
  private urlParam!: string;
  private filteredParams: any;
  private router = inject(Router);
  private currentLatitude?: number;
  private currentLongitude?: number;
  private isInitialized = false;

  public constructor(
    private modalCtrl: ModalController,
    private api: ApiService,
    private cdr: ChangeDetectorRef
  ) {
    this.router.events
      .pipe(
        filter(
          (event: Event): event is NavigationEnd =>
            event instanceof NavigationEnd
        )
      )
      .subscribe((event: NavigationEnd) => {
        if (event.url === '/tabs/location') {
          this.refreshData();
        }
      });
  }

  public ngOnInit(): void {
    this.initializeLocation();
  }

  public ionViewDidEnter(): void {
    if (!this.isInitialized) {
      this.initializeLocation();
    }
  }

  private async initializeLocation(): Promise<void> {
    if (this.isLoading) {
      return;
    }
    await this.printCurrentPosition();
  }

  private refreshData(): void {
    this.currentPage = 1;
    this.nearbyListings = [];
    this.hasMoreData = true;
    
    // Re-enable infinite scroll
    const infiniteScroll = document.querySelector('ion-infinite-scroll');
    if (infiniteScroll) {
      (infiniteScroll as any).disabled = false;
    }
    
    this.initializeLocation();
  }

  private buildUrl(page: number): string {
    if (!this.currentLatitude || !this.currentLongitude) {
      return '';
    }

    const basePath = `home/nearme/${page}`;
    const baseParams = `lat=${this.currentLatitude}&lng=${this.currentLongitude}`;

    if (!this.isFiltered) {
      return `${basePath}?${baseParams}&house_style_id=&bedroom_id=&material_id=&foundation_id=&roof_id=&state=&city=&country=&zip=&owner_name=&nrhp=&minRangeSquareFeet=1&maxRangeSquareFeet=10000&minRangeYearBuilt=&maxRangeYearBuilt=&street=`;
    }

    const params = this.filteredParams;
    return `${basePath}?${baseParams}&house_style_id=${params.houseStyle || ''}&state=${params.state || ''}&bedroom_id=${params.bedroom || ''}&material_id=${params.material || ''}&foundation_id=${params.foundation || ''}&roof_id=${params.roofType || ''}&city=${params.city || ''}&country=${params.country || ''}&zip=${params.zipCode || ''}&owner_name=${params.ownerName || ''}&nrhp=${params.nrhp ? 'on' : ''}&minRangeSquareFeet=${params.rangeSquareFeet?.lower || 1}&maxRangeSquareFeet=${params.rangeSquareFeet?.upper || 10000}&minRangeYearBuilt=${params.rangeYearBuilt?.lower || ''}&maxRangeYearBuilt=${params.rangeYearBuilt?.upper || ''}&street=${params.street || ''}`;
  }

  public printCurrentPosition = async (): Promise<void> => {
    try {
      const permissions = await Geolocation.checkPermissions();
      
      if (permissions.location === 'denied') {
        const requestResult = await Geolocation.requestPermissions({ permissions: ['location'] });
        
        if (requestResult.location !== 'granted') {
          console.error('Location permission denied');
          // Optionally show a message to the user
          return;
        }
      }

      // Get current position
      const coordinates = await Geolocation.getCurrentPosition({
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
      });

      this.currentLatitude = coordinates.coords.latitude;
      this.currentLongitude = coordinates.coords.longitude;
      this.urlParam = this.buildUrl(this.currentPage);
      
      if (this.urlParam) {
        this.isInitialized = true;
        this.nearByHomeListing(this.urlParam, this.currentPage);
      }
    } catch (error) {
      console.error('Error getting location:', error);
      // Optionally show error message to user
    }
  };

  public async clearFilter(): Promise<void> {
    this.isFiltered = false;
    this.filteredParams = null;
    this.currentPage = 1;
    this.nearbyListings = [];
    this.hasMoreData = true;
    
    // Re-enable infinite scroll
    const infiniteScroll = document.querySelector('ion-infinite-scroll');
    if (infiniteScroll) {
      (infiniteScroll as any).disabled = false;
    }
    
    if (this.currentLatitude && this.currentLongitude) {
      this.urlParam = this.buildUrl(this.currentPage);
      if (this.urlParam) {
        this.nearByHomeListing(this.urlParam, this.currentPage);
      }
    } else {
      await this.printCurrentPosition();
    }
    
    this.cdr.detectChanges();
  }

  public nearByHomeListing(url: string, page: number): void {
    if (this.isLoading) {
      return;
    }
    
    this.isLoading = true;
    this.api.nearbyListing(url).subscribe(
      (listing: NearbyListing) => {
        if (listing && listing.data && listing.data.properties) {
          if (listing.data.properties.length > 0) {
            this.nearbyListings = [
              ...this.nearbyListings,
              ...listing.data.properties,
            ];
          } else {
            this.hasMoreData = false;
            const infiniteScroll = document.querySelector('ion-infinite-scroll');
            if (infiniteScroll) {
              (infiniteScroll as any).disabled = true;
            }
          }
        }
        this.isLoading = false;
        this.completeInfiniteScroll();
        this.cdr.detectChanges();
      },
      (error) => {
        console.error('Error loading data', error);
        this.isLoading = false;
        this.completeInfiniteScroll();
      }
    );
  }

  private completeInfiniteScroll(): void {
    const infiniteScroll = document.querySelector('ion-infinite-scroll');
    if (infiniteScroll) {
      (infiniteScroll as any).complete();
    }
  }

  public loadMore(event: any): void {
    if (this.isLoading) {
      event.target.complete();
      return;
    }

    this.currentPage++;
    this.urlParam = this.buildUrl(this.currentPage);
    
    if (this.urlParam) {
      this.nearByHomeListing(this.urlParam, this.currentPage);
    } else {
      event.target.complete();
    }
  }

  public async getParams(): Promise<void> {
    try {
      const params: any = await this.api.homeParams().toPromise();
      this.params = params.data;
    } catch (error) {
      console.error('Error fetching params:', error);
    }
  }

  public async openFilterModal(): Promise<void> {
    try {
      await this.getParams();
      const modal = await this.modalCtrl.create({
        component: FilterModalComponent,
        componentProps: {
          params: this.params,
        },
      });
      await modal.present();
      const { data, role } = await modal.onWillDismiss();
      
      if (role === 'confirm' && data) {
        this.filteredParams = data;
        this.nearbyListings = [];
        this.currentPage = 1;
        this.isFiltered = true;
        this.hasMoreData = true;
        
        // Re-enable infinite scroll
        const infiniteScroll = document.querySelector('ion-infinite-scroll');
        if (infiniteScroll) {
          (infiniteScroll as any).disabled = false;
        }
        
        if (this.currentLatitude && this.currentLongitude) {
          this.urlParam = this.buildUrl(this.currentPage);
          if (this.urlParam) {
            this.nearByHomeListing(this.urlParam, this.currentPage);
          }
        } else {
          await this.printCurrentPosition();
        }
      }
    } catch (error) {
      console.error('Error opening filter modal:', error);
    }
  }
}
