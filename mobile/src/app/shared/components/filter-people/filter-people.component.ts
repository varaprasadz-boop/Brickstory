import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { FilterPeople } from '../../models/filterpeople.model';
import { ApiService } from 'src/app/core/services/api/http.service';

@Component({
  selector: 'app-filter-people',
  templateUrl: './filter-people.component.html',
  styleUrls: ['./filter-people.component.scss'],
})
export class FilterPeopleComponent  implements OnInit {
  public relationShips: any = [];
  public filterArray: FilterPeople = {
    first_name: '',
    last_name: '',
    relation: '',
    nrhp: 0,
  };
  public constructor(private modalCtrl: ModalController,public dataService: ApiService,) { }

  public ngOnInit():void {
    this.dataService.homeParams().subscribe((response: any) => {
      this.relationShips = response.data.relationship;
    });
  }

  public cancel() {
    return this.modalCtrl.dismiss(null, 'cancel');
  }

  public confirm() {
    return this.modalCtrl.dismiss(this.filterArray,'confirm');
  }
}
