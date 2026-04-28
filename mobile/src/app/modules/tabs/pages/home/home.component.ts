import { AfterViewInit, Component, inject, OnInit } from '@angular/core';
import { NavigationEnd, Router, Event } from '@angular/router';
import { MenuController, ModalController, ViewDidEnter } from '@ionic/angular';
import { filter } from 'rxjs/operators';
import { ApiService } from 'src/app/core/services/api/http.service';
import {
  HomeListing,
  Listing,
} from 'src/app/core/services/api/models/api-response.model';
import { forkJoin } from 'rxjs'; // Import forkJoin
import { register } from 'swiper/element/bundle';

register();

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent implements OnInit, ViewDidEnter {
  private currentPage = 1;
  public isLoading = false;
  private hasMoreData = true;
  public recentListing: Listing[] = [];
  public homeBanner: any = [];
  public defaultImageUrl = '../../../../../assets/img/story.png';
  private router = inject(Router);

  public constructor(public menuController: MenuController, private api: ApiService) {
    // Listen to router events and trigger refresh on route return
    this.router.events
      .pipe(
        filter(
          (event: Event): event is NavigationEnd =>
            event instanceof NavigationEnd
        )
      )
      .subscribe((event: NavigationEnd) => {
        if (event.url === '/tabs/home') {
          this.refreshData();
        }
      });
  }

  public ngOnInit(): void {
    this.refreshData();
  }

  public ionViewDidEnter(): void {
    this.refreshData(); // Refresh on view enter as well
  }

  // Consolidated API call
  private refreshData(): void {
    if (this.isLoading) {
      return;
    }
    this.isLoading = true;
    this.currentPage = 1;
    this.hasMoreData = true;
    this.recentListing = [];

    // Re-enable infinite scroll
    const infiniteScroll = document.querySelector('ion-infinite-scroll');
    if (infiniteScroll) {
      (infiniteScroll as any).disabled = false;
    }

    // Using forkJoin to combine the banner and listing API calls
    forkJoin({
      banners: this.api.homeBanners(),
      listings: this.api.homeListing(this.currentPage),
    }).subscribe(
      ({ banners, listings }) => {
        this.homeBanner = banners.data;
        this.recentListing = listings.data.recentListing;

        this.isLoading = false;
      },
      (error) => {
        console.error('Error loading data', error);
        this.isLoading = false;
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
    this.isLoading = true;
    
    this.api.homeListing(this.currentPage).subscribe(
      (listing: HomeListing) => {
        if (listing.data.recentListing && listing.data.recentListing.length > 0) {
          this.recentListing = [
            ...this.recentListing,
            ...listing.data.recentListing,
          ];
        } else {
          this.hasMoreData = false;
          event.target.disabled = true;
        }
        
        this.isLoading = false;
        event.target.complete();
      },
      (error) => {
        console.error('Error loading data', error);
        this.isLoading = false;
        event.target.complete();
      }
    );
  }

  public checkImage(url: string): Promise<boolean> {
    return new Promise((resolve) => {
      const img = new Image();
      img.onload = () => resolve(true);
      img.onerror = () => resolve(false);
      img.src = url;
    });
  }

  public getBackgroundImage(imageUrl: string): string {
    return `url('${imageUrl}')`;
  }
}
