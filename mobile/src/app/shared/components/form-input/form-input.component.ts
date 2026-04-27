import {
  ChangeDetectionStrategy,
  Component,
  Input,
} from '@angular/core';
import { FormControl, ValidatorFn, Validators } from '@angular/forms';
import {
  IonItem,
  IonLabel,
  IonInput,
  IonTextarea,
  IonNote,
} from '@ionic/angular/standalone';

@Component({
  selector: 'app-generic-input',
  standalone: false,
  template: `
    <ion-item
      [class.required-border]="isRequired()"
      lines="none"
      class="custom-item"
    >
      <ion-label position="stacked">
        {{ label }}
        <span *ngIf="isRequired()" class="required-star">*</span>
      </ion-label>

      <ng-container [ngSwitch]="type">
        <ion-textarea
          *ngSwitchCase="'textarea'"
          [formControl]="control"
          [placeholder]="placeholder"
          autoGrow="true"
          class="custom-input"
        ></ion-textarea>

        <ion-input
          *ngSwitchDefault
          [type]="type"
          [formControl]="control"
          [placeholder]="placeholder"
          class="custom-input"
        ></ion-input>
      </ng-container>
    </ion-item>

    <ion-note
      *ngIf="control.invalid && (control.dirty || control.touched)"
      color="danger"
      class="error-note"
    >
      {{ getErrorMessage() }}
    </ion-note>
  `,
  styles: [
    `
      .required-star {
        color: red;
        margin-left: 2px;
      }

      .custom-item {
        --background: white;
        border-radius: 12px;
        margin-bottom: 12px;
      }

      .custom-input {
        font-size: 1.1rem;
        padding: 10px;
      }

      .required-border {
        border-left: 3px solid red;
        border-radius: 12px;
      }

      .error-note {
        font-size: 0.9rem;
        margin-left: 4px;
      }
    `,
  ],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FormInput {
  @Input() label = '';
  @Input() placeholder = '';
  @Input() type:
    | 'text'
    | 'email'
    | 'password'
    | 'tel'
    | 'textarea'
    | 'address' = 'text';
  @Input({ required: true }) control!: FormControl;

  isRequired(): boolean {
    if (!this.control?.validator) return false;
    const validator = this.control.validator({} as any);
    return validator?.['required'] ? true : false;
  }

  getErrorMessage(): string {
    if (this.control.hasError('required')) {
      return `${this.label} is required`;
    }
    if (this.control.hasError('email')) {
      return `Please enter a valid email`;
    }
    if (this.control.hasError('minlength')) {
      const required = this.control.getError('minlength').requiredLength;
      return `Minimum length is ${required}`;
    }
    if (this.control.hasError('maxlength')) {
      const required = this.control.getError('maxlength').requiredLength;
      return `Maximum length is ${required}`;
    }
    return 'Invalid input';
  }
}
