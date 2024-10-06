import { Planning } from '@/planning/domain/valueobject/planning'

import { Resource } from '@/planning/domain/entity/resource'

export class WorkSchedule {
  private constructor(
    public readonly resource: Resource,
    public readonly planning: Planning
  ) {}

  public static create(resource: Resource, planning: Planning): WorkSchedule {
    return new WorkSchedule(resource, planning)
  }
}
