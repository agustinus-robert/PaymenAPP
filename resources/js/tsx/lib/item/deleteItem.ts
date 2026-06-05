import { deletePageFromDataBase } from "./utils";

export async function deleteItem(id: string) {
  return deletePageFromDataBase(id);
}
