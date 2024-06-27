import { EstateItemType } from "@/enums/estate-item";

export interface EstateItem {
    id: number,
    preview: string,
    description: string,
    rooms: number,
    floor: number,
    type: EstateItemType,
    yearOfBuild: number,
    square: number,
    bedrooms: number,
    hasParking: boolean,
    lat: Number,
    lng: Number,
    price: number,
    features: string[],
}
