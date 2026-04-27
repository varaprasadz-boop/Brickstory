export interface TimelineEvent {
    id?: number | string;
    person_photo?: string;
    first_name: string;
    last_name: string;
    from_date: string; // Date string
    indicator?: string; // For moved in/out
    story_photo?: string; // For sub-timeline events
    description?: string; // Story description
    setting?: string;
    season?: string;
    event?: string;
    side_of_house?: string;
    room?: string;
    user_id:number;
    living:string;
  }