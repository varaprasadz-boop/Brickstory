import {
  Component,
  OnInit,
  NgZone,
  ViewChild,
  ElementRef,
} from '@angular/core';
import { ModalController, Platform } from '@ionic/angular';
import { Geolocation } from '@capacitor/geolocation';
import { PlaceService } from 'src/app/core/services/places/place.service';

declare var google: any;

@Component({
  selector: 'app-auto-complete',
  templateUrl: './auto-complete.page.html',
  styleUrls: ['./auto-complete.page.scss'],
})
export class AutoCompletePage implements OnInit {
  @ViewChild('map', { static: true }) mapEle!: ElementRef;
  public autocompleteItems: any;
  public map: any;
  public marker: any;
  public autocomplete: any;
  public acService: any;
  public placesService: any;
  public latitude!: number;
  public longitude!: number;
  public latlong: any;
  public location: any;
  public address: any;
  public service = new google.maps.places.AutocompleteService();
  public locality: any;
  private searchTimeout: any;
  // US state abbreviation to full name map
  private readonly STATE_MAP: { [key: string]: string } = {
    AL: 'Alabama',
    AK: 'Alaska',
    AZ: 'Arizona',
    AR: 'Arkansas',
    CA: 'California',
    CO: 'Colorado',
    CT: 'Connecticut',
    DE: 'Delaware',
    DC: 'District Of Columbia',
    FL: 'Florida',
    GA: 'Georgia',
    HI: 'Hawaii',
    ID: 'Idaho',
    IL: 'Illinois',
    IN: 'Indiana',
    IA: 'Iowa',
    KS: 'Kansas',
    KY: 'Kentucky',
    LA: 'Louisiana',
    ME: 'Maine',
    MD: 'Maryland',
    MA: 'Massachusetts',
    MI: 'Michigan',
    MN: 'Minnesota',
    MS: 'Mississippi',
    MO: 'Missouri',
    MT: 'Montana',
    NE: 'Nebraska',
    NV: 'Nevada',
    NH: 'New Hampshire',
    NJ: 'New Jersey',
    NM: 'New Mexico',
    NY: 'New York',
    NC: 'North Carolina',
    ND: 'North Dakota',
    OH: 'Ohio',
    OK: 'Oklahoma',
    OR: 'Oregon',
    PA: 'Pennsylvania',
    RI: 'Rhode Island',
    SC: 'South Carolina',
    SD: 'South Dakota',
    TN: 'Tennessee',
    TX: 'Texas',
    UT: 'Utah',
    VT: 'Vermont',
    VA: 'Virginia',
    WA: 'Washington',
    WV: 'West Virginia',
    WI: 'Wisconsin',
    WY: 'Wyoming',
  };

  constructor(
    public placeService: PlaceService,
    public viewCtrl: ModalController,
    public zone: NgZone,
    public platform: Platform
  ) {}

  ngOnInit() {
    // set autocomplete query empty
    this.acService = new google.maps.places.AutocompleteService();
    this.autocompleteItems = [];
    this.autocomplete = {
      query: '',
    };
    this.getLocation();
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }

  remove() {
    this.autocompleteItems = [];
    this.autocomplete = {
      query: '',
    };
  }

  // get current location as map center
  getLocation() {
    this.platform.ready().then(async () => {
      await Geolocation.getCurrentPosition({
        maximumAge: 3000,
        timeout: 10000,
        enableHighAccuracy: false,
      }).then((resp) => {
        if (resp) {
          console.log('resp', resp);
          this.latitude = resp.coords.latitude;
          this.longitude = resp.coords.longitude;
          this.loadmap(
            resp.coords.latitude,
            resp.coords.longitude,
            this.mapEle
          );
          this.getAddress(this.latitude, this.longitude);
        }
      });
    });
  }

  //load map
  loadmap(lat: number, lng: number, mapElement: ElementRef<any>) {
    const location = new google.maps.LatLng(lat, lng);
    const style = [
      {
        featureType: 'all',
        elementType: 'all',
        stylers: [{ saturation: -100 }],
      },
    ];
    const mapOptions = {
      zoom: 15,
      scaleControl: false,
      streetViewControl: false,
      zoomControl: false,
      overviewMapControl: false,
      center: location,
      mapTypeControl: false,
      mapTypeControlOptions: {
        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'Deal'],
      },
    };
    this.map = new google.maps.Map(mapElement.nativeElement, mapOptions);
    var mapType = new google.maps.StyledMapType(style, { name: 'Grayscale' });
    this.map.mapTypes.set('Deal', mapType);
    this.map.setMapTypeId('Deal');
    this.addMarker(location);
    let geocoder = new google.maps.Geocoder();
    geocoder.geocode(
      { latLng: this.map.getCenter() },
      (results: string | any[], status: any) => {
        if (status == google.maps.GeocoderStatus.OK) {
          // save locality
          this.locality = this.placeService.setLocalityFromGeocoder(results);
          console.log('locality', this.locality);
        }
      }
    );
  }

  // get address from latitude and longitude
  getAddress(lat: number, lng: number) {
    const geocoder = new google.maps.Geocoder();
    const location = new google.maps.LatLng(lat, lng);
    geocoder.geocode(
      { location: location },
      (results: any, status: any) => {
        const r = Array.isArray(results) ? results as any[] : [];
        console.log(r);
        if (r && r.length) {
          const parsed = this.parseAddressComponents(r);
          this.address = parsed.address;
          this.latitude = lat;
          this.longitude = lng;
          this.locality = parsed.locality;
          // expose city/state/zip for parent
          this.location = {
            lat: this.latitude,
            long: this.longitude,
            address: this.address,
            locality: this.locality,
            city: parsed.city,
            state: parsed.state,
            state_code: parsed.state_code,
            zip: parsed.zip,
          };
        }
      }
    );
  }

  // add marker to map
  addMarker(location: any) {
    console.log('location =>', location);
    //custom icon
    /*const icon = {
      url: 'assets/icon/marker.png',
      scaledSize: new google.maps.Size(50, 50), // scaled size
    }*/
    this.marker = new google.maps.Marker({
      position: location,
      map: this.map,
      //icon: icon,
      draggable: true,
      animation: google.maps.Animation.DROP,
    });
    google.maps.event.addListener(this.marker, 'dragend', () => {
      console.log(this.marker);
      this.getDragAddress(this.marker);
    });
  }

  // drag marker to get new address on map
  getDragAddress(event: {
    position: { lat: () => number; lng: () => number };
  }) {
    const geocoder = new google.maps.Geocoder();
    const location = new google.maps.LatLng(
      event.position.lat(),
      event.position.lng()
    );
    geocoder.geocode(
      { location: location },
      (results: { formatted_address: any }[], status: any) => {
        console.log(results);
        if (results && results.length) {
          const parsed = this.parseAddressComponents(results);
          this.address = parsed.address;
          this.latitude = event.position.lat();
          this.longitude = event.position.lng();
          this.locality = parsed.locality;
          // update current location
          this.location = {
            lat: this.latitude,
            long: this.longitude,
            address: this.address,
            locality: this.locality,
            city: parsed.city,
            state: parsed.state,
            state_code: parsed.state_code,
            zip: parsed.zip,
          };
        }
      }
    );
  }

  select() {
    // Preserve any parsed city/state/zip if available
    const city = this.location && this.location.city ? this.location.city : '';
    const state = this.location && this.location.state ? this.location.state : '';
    const zip = this.location && this.location.zip ? this.location.zip : '';
    this.location = {
      lat: this.latitude,
      long: this.longitude,
      address: this.address,
      locality: this.locality,
      city: city,
      state: state,
      zip: zip,
    };
    this.viewCtrl.dismiss(this.location);
  }

  chooseItem(item: any) {
    // Hide the autocomplete list immediately
    this.autocompleteItems = [];
    this.autocomplete.query = '';
    
    //convert Address to lat and long
    let geocoder = new google.maps.Geocoder();
    geocoder.geocode(
      { address: item },
      (results: any, status: any) => {
        const r = Array.isArray(results) ? results as any[] : [];
        if (r && r.length) {
          this.latitude = r[0].geometry.location.lat();
          this.longitude = r[0].geometry.location.lng();
          // parse address components to get city/state/zip/locality
          const parsed = this.parseAddressComponents(r);
          // Use the autocomplete suggestion text as address (what user saw), not full geocoded formatted_address
          this.address = item;
          this.locality = parsed.locality;
          this.location = {
            lat: this.latitude,
            long: this.longitude,
            address: this.address,
            locality: this.locality,
            city: parsed.city,
            state: parsed.state,
            state_code: parsed.state_code,
            zip: parsed.zip,
          };
          // Load the map and show marker so user can confirm or drag it
          this.loadmap(this.latitude, this.longitude, this.mapEle);
          // Do NOT call getAddress() here - it would overwrite this.address with full formatted address.
          // We already have city/state/zip from parseAddressComponents above; keep autocomplete text as address.
          // Do NOT dismiss the modal immediately. Let the user review on the map and press Select.
        }
      }
    );
  }

  // Parse google geocoder results to extract address, city, state and zip
  private parseAddressComponents(results: any[]): { address: string; city: string; state: string; state_code?: string; zip: string; locality: any } {
    try {
      const res = results[0] || results.find(r => r.formatted_address);
      const components = res.address_components || [];
      let city = '';
      let state = '';
      let stateCode = '';
      let zip = '';
      // prefer locality/postal_town, fall back to sublocality/neighborhood/administrative_area_level_2
      for (let i = 0; i < components.length; i++) {
        const comp = components[i];
        if (!city && (comp.types.indexOf('locality') > -1 || comp.types.indexOf('postal_town') > -1)) {
          city = comp.long_name;
        }
        if (!city && (comp.types.indexOf('sublocality') > -1 || comp.types.indexOf('sublocality_level_1') > -1 || comp.types.indexOf('neighborhood') > -1)) {
          city = comp.long_name;
        }
        if (!city && comp.types.indexOf('administrative_area_level_2') > -1) {
          city = comp.long_name;
        }
        if (!state && comp.types.indexOf('administrative_area_level_1') > -1) {
          // comp.short_name is usually the state code (e.g., 'NY')
          stateCode = comp.short_name;
          // Map to full name when possible
          state = this.STATE_MAP[comp.short_name] || comp.long_name || comp.short_name;
        }
        if (!zip && comp.types.indexOf('postal_code') > -1) {
          zip = comp.long_name;
        }
      }
      const address = res.formatted_address || '';
      const locality = this.placeService.setLocalityFromGeocoder(results) || null;
      return { address, city, state, state_code: stateCode, zip, locality };
    } catch (e) {
      return { address: results && results[0] ? results[0].formatted_address : '', city: '', state: '', zip: '', locality: null };
    }
  }

  updateSearch() {
    // Clear previous timeout if exists
    if (this.searchTimeout) {
      clearTimeout(this.searchTimeout);
    }

    // Autocomplete search, if autocomplete query is empty return list of items in an array
    if (this.autocomplete.query == '') {
      this.autocompleteItems = [];
      return;
    }

    // Add debouncing to prevent too many API calls
    this.searchTimeout = setTimeout(() => {
      this.performSearch();
    }, 300);
  }

  private performSearch() {
    // Places prediction, you can add more to it
    let me = this;
    this.service.getPlacePredictions(
      {
        input: this.autocomplete.query,
        componentRestrictions: { country: ['USA'] },
      },
      (predictions: any[] | null, status: any) => {
        me.autocompleteItems = [];
        me.zone.run(() => {
          if (predictions != null) {
            // Limit results to 5 for better UX
            predictions.slice(0, 5).forEach((prediction: { description: any }) => {
              me.autocompleteItems.push(prediction.description);
            });
          }
        });
      }
    );
  }
}
