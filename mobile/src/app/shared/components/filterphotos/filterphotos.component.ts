import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { ApiService } from 'src/app/core/services/api/http.service';
import { ParamsData } from 'src/app/core/services/api/models/api-response.model';
import { FilterArray } from '../../models/filter.model';
@Component({
  selector: 'app-filterphotos',
  templateUrl: './filterphotos.component.html',
  styleUrls: ['./filterphotos.component.scss'],
})
export class FilterphotosComponent implements OnInit {
  public params!: ParamsData;
  public showRoomSelect: boolean = true;
  public settings: any = [];
  public room: any = [];
  public season: any = [];
  public event: any = [];
  public sideOfHouse: any = [];
  public filterArray: any = {
    houseSide: '',
    events: '',
    season: '',
    setting: '',
    room: '',
    nrhp: 0,
  };
  public constructor(
    private modalCtrl: ModalController,
    private api: ApiService,
    private route: ActivatedRoute
  ) {}

  public ngOnInit() {
    this.api.homeParams().subscribe((response: any) => {
      this.params = response.data; 
      this.room = this.params.rooms;
      this.event = this.params.events;
      this.settings = this.params.settings;
      this.season = this.params.season;
      this.sideOfHouse = this.params.side_of_house;
    });
  }
  public cancel() {
    return this.modalCtrl.dismiss(null, 'cancel');
  }

  public confirm() {
    return this.modalCtrl.dismiss(this.filterArray, 'confirm');
  }

  public onSettingChange(value: string) {
    this.showRoomSelect = value === 'Indoors';
  }
  public onSelectableChange(event: any, type: string): void { 
    if (type === 'events') {
      this.filterArray.events = event;
    } else if (type === 'room') {
      this.filterArray.room = event;
    }
  }
}
