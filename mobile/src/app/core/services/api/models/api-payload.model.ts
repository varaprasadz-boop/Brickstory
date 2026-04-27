// login
export interface Login {
  email: string;
  password: string;
}
// forget
export interface ForgetPasssword {
  email: string;
}
// signup
export interface Signup {
  firstname: string;
  lastname: string;
  email: string;
  password: string;
  confirm_password: string;
}
// Update Profile
export interface UpdateProfile {
  user_id: number;
  firstname: string;
  lastname: string;
  email: string;
  address: string;
  city: string;
  state: string;
  zip: string;
}
export interface addHome {
  user_id: number;
  address1: string;
  city: string;
  owner_name: string;
  architech: string;
  square_feet: string;
  address2: string;
  state: string;
  zip: string;
  image_source:string;
  home_profile_photo:string;
  year_built: string;
  house_style_id: string;
  bedroom_id: string;
  material_id: string;
  from_date: string;
  to_date: string;
}
export interface photosAndHistory{
  id: string;
  user_id: string;
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
  city: string;
  state: string;
  season_value: string | null;
  event_value: string | null;
  side_of_house_value: string;
  room_value: string | null;
}

