export interface IStory {
  id: string;
  user_id: string;
  master_story_id: string;
  story_photo: string;
  approximate_date: string; // Format YYYY-MM-DD
  from_date: string; // Format YYYY-MM-DD
  to_date: string; // Format YYYY-MM-DD
  setting_id: string;
  setting_value: string;
  season_id: string;
  event_id: string;
  side_of_house_id: string;
  room_id: string;
  story_description: string;
  style: string;
  soul: string;
  created_on: string; // Format YYYY-MM-DD HH:MM:SS
  updated_on: string; // Format YYYY-MM-DD HH:MM:SS
  full_story_photo: string;
  city: string;
  state: string;
  season_value: string;
  event_value: string;
  side_of_house_value: string;
  room_value: string;
}
export interface IPeople {
  user_id: string;
  property_id: string;
  from_date: string | null;
  to_date: string | null;
  first_name: string;
  last_name: string;
  relation_id: string;
  born_date: string | null;
  died_date: string | null;
  living: number;
  image: string;
  image_source: string;
}
export interface IMinDates {
  from_date: string;
  born_date: string;
}