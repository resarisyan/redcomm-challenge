import { object, string, type InferType } from 'yup';

export const createNoteSchema = object({
  title: string().required(),
  desc: string().required(),
});
export type CreateNoteSchema = InferType<typeof createNoteSchema>;

export const updateNoteSchema = object({
  title: string().optional(),
  desc: string().optional(),
});
export type UpdateNoteSchema = InferType<typeof updateNoteSchema>;
