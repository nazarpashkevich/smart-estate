import { EstateItemType } from "@/enums/estate-item";
import { Location } from "@/contracts/location";

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
    location: Location,
    price: number,
    features: string[],
}
