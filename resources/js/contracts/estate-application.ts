import { EstateApplicationStatus } from "@/enums/estate-application";

export interface EstateApplication {
    id: number,
    name: string,
    phone: string,
    suggestedPrice: {
        value: number,
        format: string
    },
    status: EstateApplicationStatus,
    estateItemId: number,
}
