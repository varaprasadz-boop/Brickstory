export interface FilterArray {
    state: string;
    houseStyle: string;
    bedroom: string;
    yearBuilt: string;
    material: string;
    foundation: string;
    roofType: string;
    sqFt: string;
    street: string;
    city: string;
    country: string;
    nearBy: string;
    zipCode: string;
    ownerName: string;
    rangeYearBuilt: RangeEvent;
    rangeSquareFeet:RangeEvent;
    rangeMile:RangeEvent;
    nrhp: boolean;
}
interface RangeEvent {
    lower:string;
    upper:string;
}