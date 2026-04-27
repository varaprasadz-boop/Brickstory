import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { StorageService } from '../services/storage/storage.service';

export const permissionGuard: CanActivateFn = (route, state) => {
  const router = inject(Router);
  const localStorage = inject(StorageService);

  const userLoggedIn: boolean = localStorage.isLoggedIn();
  if (!userLoggedIn) {
    router.navigate(['/auth/intro']);
    return false;
  } else {
    return true;
  }
};
