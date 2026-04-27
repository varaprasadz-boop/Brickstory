export interface LoginResponse {
  status: string;
  message: string;
  data: Data[];
}
export interface Data {
  id: string;
  role_id: string;
  firstname: string;
  lastname: string;
  email: string;
  password: string;
  fb_id: string | null;
  address: string | null;
  city: string | null;
  state: string | null;
  zip: string | null;
  profile_photo: string | null;
  activation_code: string;
  activation_expiry: string;
  last_login: string | null;
  status: string;
  created: string;
  modified: string;
  is_locked: string;
  lock_datetime: string;
  lock_user_id: string;
}
// signup
export interface SignupResponse {
  status: string;
  message: string;
  data: null | { error: string };
}
// Update Profile
export interface UpdateProfileResponse {
  status: string;
  message: string;
  data: null | { error: string };
}
// forget password
export interface forgetPasswordResponse {
  status: string;
  message: string;
  data: null | { error: string };
}
// home listing
export interface HomeListing {
  status: string;
  message: string;
  data: {
    properties: Listing[];
    recentListing: Listing[];
    featureStory: Story[];
    storiesCount: number;
    peoplesCount: number;
    housesCount: number;
    citiesCount: {
      total: string;
    };
  };
}
export interface Listing {
  id: string;
  user_id: string;
  address1: string;
  address2: string;
  city: string;
  state: string;
  zip: string;
  year_built: string;
  house_style_id: string;
  square_feet: string;
  architech: string;
  distance?: number; // Optional
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
  monitor_home: string; // New field
  monitor_phone: string; // New field
  status: string; // New field
}

export interface Story {
  id: string;
  story_photo: string;
  state: string;
  year_built: string;
  zip: string;
  city: string;
}
// Params
export interface DropdownParams {
  status: string;
  message: string;
  data: ParamsData;
}

export interface ParamsData {
  bedroom: string[];
  house_style: Record<string, string>;
  material: Record<string, string>[];
  foundation: Record<string, string>;
  roof: Record<string, string>;
  events: Record<string, string>;
  season: Record<string, string>;
  states: Record<string, string>;
  settings: Record<string, string>;
  side_of_house: Record<string, string>;
  relationship: Record<string, string>;
  rooms: Record<string, string>;
}
// Nearby

export interface NearbyListing {
  status: string;
  message: string;
  data: {
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
  };
}
// Home Details
export interface Home {
  id: string;
  user_id: string;
  address1: string;
  address2: string;
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
  status: string;
  house_style_value: string;
  material_value: string;
  roof_value: string | null;
  foundation_value: string | null;
  bedroom_value: string;
}

export interface SubStory {
  id: string;
  user_id: number;
  master_story_id: string;
  story_photo: string;
  approximate_date: string;
  from_date: string;
  to_date: string;
  setting_id: string;
  season_id: string;
  event_id: string;
  side_of_house_id: string;
  room_id: string;
  story_description: string;
  style: string;
  soul: string;
  created_on: string;
  updated_on: string;
  season_value: string | null;
  event_value: string | null;
  side_of_house_value: string | null;
  room_value: string | null;
}

export interface SubPerson {
  id: string;
  user_id: string;
  master_story_id: string;
  person_photo: string;
  frist_name: string;
  last_name: string;
  relation_id: string;
  relationship_value: string | null;
  from_date: string;
  to_date: string;
  born_date: string;
  died_date: string;
  living: string;
  created_on: string;
  updated_on: string;
}

export interface PropertyDetails {
  home: Home;
  sub_stories: SubStory[];
  livedhere: any[];
  sub_persons: SubPerson[];
}

export interface ApiResponse {
  status: string;
  message: string;
  data: PropertyDetails;
}
