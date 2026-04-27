import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-about-brick',
  templateUrl: './about-brick.component.html',
  styleUrls: ['./about-brick.component.scss'],
})
export class AboutBrickComponent  implements OnInit {

  public constructor(public router:Router) { }

  public ngOnInit() {}
  
  public back(){
    window.open(`https://brickstory.com/aboutus`);
  }
}
