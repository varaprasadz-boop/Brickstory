import { Component, Input, OnInit } from '@angular/core';
import { photosAndHistory } from 'src/app/core/services/api/models/api-payload.model';
import { environment } from 'src/environments/environment';
import { DatePipe } from '@angular/common';
import { Router } from '@angular/router';
import { ApiService } from 'src/app/core/services/api/http.service';
import { ViewDidEnter } from '@ionic/angular';
@Component({
  selector: 'app-photocomponent',
  templateUrl: './photocomponent.component.html',
  styleUrls: ['./photocomponent.component.scss'],
})
export class PhotocomponentComponent implements OnInit {
  @Input() public photoAndStories!: photosAndHistory;
  public states: any;
  public allstates: any;
  public imageUrl: string = environment.imageUrl;
  public defaultImage = '../../../../assets/img/story.png';
  public backgroundStyle: string = '../../../../assets/img/story.png';
  public constructor(
    private datePipe: DatePipe,
    public router: Router,
    public dataService: ApiService
  ) {}

  public ngOnInit() {
    this.checkImage(this.photoAndStories.story_photo).then((isValid) => {
      this.backgroundStyle = `url(${
        isValid ? this.photoAndStories.story_photo : this.defaultImage
      })`;
    });
  }
  public getYear(dateString: string): string {
    if (!dateString || dateString === '0000-00-00') {
      return ''; // or just return an empty string if you want to hide it
    }
    return this.datePipe.transform(dateString, 'yyyy') || '';
  }

  public checkImage(url: string): Promise<boolean> {
    return new Promise((resolve) => {
      const img = new Image();
      img.onload = () => resolve(true);
      img.onerror = () => resolve(false);
      img.src = url;
    });
  }
  public homeDetails(): void {
    this.router.navigate([
      '/screens/view-detail',
      this.photoAndStories.master_story_id,
      'timeline',
      this.photoAndStories.id,
    ]);
  }
  public openMap(lng: any, lat: any): void {
    window.open(`https://maps.google.com/?q=${lng},${lat}`);
  }
}
