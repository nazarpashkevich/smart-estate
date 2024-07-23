import { ChatMessage } from "@/contracts/ai-chat";
import axios from "axios";

export default class {
    public async history(): Promise<ChatMessage[]> {
        const result = await axios.get(route('ai.chat.index'));

        return result.data;
    }

    public async getInitMessage(): Promise<string> {
        const result = await axios.get(route('ai.chat.init-message'));

        return result.data.message ?? '';
    }

    public async send(message: string, callback: (e: string) => void): Promise<ChatMessage> {
        const result = await axios.get(
            route('ai.chat.send'),
            { params: { message }, responseType: 'stream', adapter: 'fetch' }
        );


        // consume response
        const reader = result.data.pipeThrough(new TextDecoderStream()).getReader();
        while (true) {
            const { value, done } = await reader.read();
            if (done) {
                break;
            }

            callback(value);
        }

        return result.data;
    }

    public async deleteChat(): Promise<void> {
        await axios.delete(route('ai.chat.clear'));
    }
}
