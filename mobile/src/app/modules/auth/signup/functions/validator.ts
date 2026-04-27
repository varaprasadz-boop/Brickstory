import { AbstractControl, NgForm, ValidatorFn } from '@angular/forms';

// export function comparePasswords(passwordControlName: string, confirmPasswordControlName: string): ValidatorFn {
//   return (formGroup: AbstractControl): { [key: string]: any } | null => {
//     const password = formGroup.get(passwordControlName);
//     const confirmPassword:any = formGroup.get(confirmPasswordControlName);

//     if (password && confirmPassword && password.value !== confirmPassword.value) {
//       confirmPassword.setErrors({ compareWith: true });
//       return { compareWith: true };
//     } else {
//       confirmPassword.setErrors(null);
//       return null;
//     }
//   };
// }
export function comparePasswords(form: NgForm) {
    const password = form.form.value.password;
    const confirmPassword = form.value.confirmPassword;
    
    return password === confirmPassword ? null : { passwordMismatch: true };
  }
  