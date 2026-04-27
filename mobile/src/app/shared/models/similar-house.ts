export interface ISimilarHouse {
  get: Get;
  pagelink: string;
  limit: string;
  page: number;
  real_page: number;
  properties: IHouse[];
  count: number;
  total_pages: number;
}

export interface Get {
  street: string;
}

export interface IHouse {
  id: string;
  user_id: string;
  address1: string;
  address2: string;
  image_source?: string;
  city: string;
  state: string;
  zip: string;
  year_built: string;
  house_style_id: string;
  square_feet: string;
  architech: string;
  owner_name: string;
  bedroom_id: string;
  material_id: string;
  lived_here: string;
  from_date: string;
  to_date: string;
  home_profile_photo: string;
  lat: string;
  lng: string;
  NRHP: string;
  NRHP_Date: string;
  Acres: string;
  County: string;
  Property_Name: string;
  foundation_id: string;
  roof_id: string;
  External_Link: string;
  monitor_home: string;
  monitor_phone?: string;
  status: string;
}
