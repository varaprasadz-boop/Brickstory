import { TestBed } from '@angular/core/testing';

import { PhotoPreviewService } from './photo-preview.service';

describe('PhotoPreviewService', () => {
  let service: PhotoPreviewService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PhotoPreviewService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
