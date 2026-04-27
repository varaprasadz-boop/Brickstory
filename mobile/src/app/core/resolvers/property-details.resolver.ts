// property-details.resolver.ts
import { Injectable } from '@angular/core';
import { Resolve, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { delay, finalize, map, Observable, tap } from 'rxjs';
import { ApiService } from 'src/app/core/services/api/http.service';
import { PropertyDetails } from 'src/app/core/services/api/models/api-response.model';
import { LoadingService } from '../services/loading/loading.service';

@Injectable({
  providedIn: 'root',
})
export class PropertyDetailsResolver implements Resolve<PropertyDetails> {
  constructor(
    private apiService: ApiService,
    private loadingService: LoadingService
  ) {}

  public resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<PropertyDetails> {
    const id = route.paramMap.get('id');
    
    // Show loading
    this.loadingService.showLoading(5000);
    
    return this.apiService.homeDetail(Number(id)).pipe(
      map((res: any) => res),
      finalize(() => {
        // Dismiss loading when request completes
        this.loadingService.loadingCtrl.dismiss();
      })
    );
  }
}
