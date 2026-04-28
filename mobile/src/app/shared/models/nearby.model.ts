import { Listing } from "src/app/core/services/api/models/api-response.model";

interface NearbyListing {
    get: {
        lat: string;
        lng: string;
        house_style_id: string;
        state: string;
        bedroom_id: string;
        material_id: string;
        foundation_id: string;
        roof_id: string;
        city: string;
        country: string;
        zip: string;
        owner_name: string;
        nrhp: string;
        minRangeSquareFeet: string;
        maxRangeSquareFeet: string;
        minRangeYearBuilt: string;
        maxRangeYearBuilt: string;
        street: string;
    };
    pagelink: number;
    limit: string;
    page: number;
    real_page: number;
    properties: Listing[];
    count: number;
    total_pages: number;
}
