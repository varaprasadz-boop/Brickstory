import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { StorageService } from '../services/storage/storage.service';

export const authGuard: CanActivateFn = (route, state) => {
  const router = inject(Router);
  const localStorage = inject(StorageService);

  const userLoggedIn: boolean = localStorage.isLoggedIn();
  if (!userLoggedIn) {
    return true;
  } else {
    if (route.routeConfig?.path === '' || route.routeConfig?.path === '/auth') {
      router.navigate(['/tabs/home']);
    }
    return false;
  }
};
