import axios from "axios";
import { EstateItem } from "@/contracts/estate-item";

export default class {
    public async find(id: number): Promise<EstateItem> {
        const result = await axios.get(
            route('api.estate.show', id),
            { data: null, headers: { 'Content-Type': 'application/json' } }
        );

        return result.data?.data;
    }
}
