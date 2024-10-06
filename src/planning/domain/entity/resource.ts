export class Resource {
  private constructor(public readonly id: string) {}

  public static of(id: string): Resource {
    return new Resource(id)
  }
}
