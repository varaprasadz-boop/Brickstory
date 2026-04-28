import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ApiService } from 'src/app/core/services/api/http.service';

@Component({
  selector: 'app-my-timeline',
  templateUrl: './my-timeline.component.html',
  styleUrls: ['./my-timeline.component.scss'],
})
export class MyTimelineComponent implements OnInit {
  public uid: any;
  public defaultImage = '../../../../../assets/img/story.png';
  public myTimeLine: any = [];
  public constructor(public dataService: ApiService, public router: Router) {
    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.uid = user.id;
    this.dataService.myTimeLine(this.uid).subscribe((data) => {
      this.myTimeLine = data.data;
    });
  }

  public ngOnInit() {}
  public onImageError(event: any) {
    event.target.src = this.defaultImage;
  }
}
