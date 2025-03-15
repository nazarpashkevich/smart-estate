import { Location } from '@/contracts/location';
import { EstateItemType } from '@/enums/estate-item';

export interface EstateItem {
  id: number;
  title: string;
  preview: string;
  description: string;
  rooms: number;
  floor: number;
  type: EstateItemType;
  yearOfBuild: number;
  square: number;
  bedrooms: number;
  hasParking: boolean;
  location: Location;
  price: {
    value: number;
    format: string;
  };
  features: string[];
}
