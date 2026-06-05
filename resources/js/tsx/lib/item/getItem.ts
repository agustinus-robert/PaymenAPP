import { Item } from "./types";
import { getPageFromDataBase } from "./utils";

type Query = {
  id: string;
};

export async function getItem(query: Query): Promise<Item> {
  const { id } = query;

  return getPageFromDataBase(id);
}
