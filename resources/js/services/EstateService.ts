import { EstateItem } from '@/contracts/estate-item';
import axios from 'axios';

export default class {
  public async find(id: number): Promise<EstateItem> {
    const result = await axios.get(route('api.estate.show', id), {
      data: null,
      headers: { 'Content-Type': 'application/json' },
    });

    return result.data?.data;
  }
}
