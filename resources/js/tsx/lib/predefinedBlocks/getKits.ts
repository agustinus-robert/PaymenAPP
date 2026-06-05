const kit = {
  id: "1",
  title: "DefaultKit",
};

const kitType = {
  id: "1",
  name: "base",
  title: "Base kit",
};

const availableKits = [kit];

const style = {
  id: "1",
  title: "Style #1",
  fontStyles: [],
  colorPalette: [
    {
      id: "color1" as const,
      hex: "#cccccc",
    },
  ],
};

interface Category {
  id: string;
  slug: string;
  name: string;
  title: string;
}

export function getKits(): Promise<Array<typeof kit>> {
  return Promise.resolve(availableKits);
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars
export async function getKitsMeta(_: string): Promise<{
  id: string;
  // eslint-disable-next-line
  blocks: Array<any>;
  categories: Array<Category>;
  types: Array<typeof kitType>;
  name: string;
  styles: Array<typeof style>;
}> {
  const blocksMeta = await import("./blocks/meta.json").then((f) => f.default);
  // uniq categories
  const categories = new Set(blocksMeta.map((f) => f.cat).flat());

  return {
    id: kit.id,
    name: kit.title,
    blocks: blocksMeta,
    categories: Array.from(categories).map((cat) => ({
      id: cat,
      slug: cat,
      name: cat,
      title: cat,
    })),
    types: [kitType],
    styles: [style],
  };
}

export async function getKitsBlockData(blockId: string) {
  const blocksData = await import("./blocks/blocks.json").then((f) => f.default);
  const block = blocksData.find((b) => b.id === blockId);

  if (!block) {
    throw new Error(`Fail to get block ${blockId}`);
  }
  return block.data;
}
