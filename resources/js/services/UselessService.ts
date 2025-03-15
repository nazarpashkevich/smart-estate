import axios from 'axios';

class UselessService {
  public async randomFact(): Promise<string> {
    // @todo move to backend
    const result = await axios
      .get('https://uselessfacts.jsph.pl/api/v2/facts/random', {
        withCredentials: false,
      })
      .then((res) => res.data);

    return result.text ?? '';
  }
}

export default new UselessService();
