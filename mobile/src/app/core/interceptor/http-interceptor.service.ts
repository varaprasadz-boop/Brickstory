import { Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { finalize } from 'rxjs/operators';
import { LoadingService } from '../services/loading/loading.service';

@Injectable({
  providedIn: 'root'
})
export class HttpInterceptorService implements HttpInterceptor {

  constructor(private loading: LoadingService) {}

  intercept(
    req: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const method = req.method.toUpperCase();

    const isMutating = ['POST', 'PUT', 'PATCH', 'DELETE'].includes(method);

    if (isMutating) {
      // Show loading for write operations only
      let delayDuration = method === 'POST' ? 8000 : 2000;
      this.loading.showLoading(delayDuration);
    }

    return next.handle(req).pipe(
      finalize(() => {
        if (isMutating) {
          this.loading.loadingCtrl.dismiss();
        }
      })
    );
  }
}
