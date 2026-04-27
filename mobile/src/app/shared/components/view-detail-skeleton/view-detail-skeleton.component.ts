import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-view-detail-skeleton',
  templateUrl: './view-detail-skeleton.component.html',
  styleUrls: ['./view-detail-skeleton.component.scss'],
})
export class ViewDetailSkeletonComponent {
  @Input() segment: string = 'details';
  
  public storiesItems = Array(3).fill(0);
  public peopleItems = Array(2).fill(0);
  public timelineItems = Array(4).fill(0);
}
