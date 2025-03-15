import { ChatRole } from '@/enums/ai-chat';

export interface ChatMessage {
  id: number;
  text: string;
  role: ChatRole;
  createdAt: Date;
}
