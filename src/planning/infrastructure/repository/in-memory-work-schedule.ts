import { WorkScheduleRepository } from '@/planning/domain/repository/work-schedule'
import { WorkSchedule } from '@/planning/domain/entity/work-schedule'
import { Resource } from '@/planning/domain/entity/resource'

export class InMemoryWorkScheduleRepository implements WorkScheduleRepository {
  private readonly workScheduleByResource = new Map<string, WorkSchedule>()

  public async save(workSchedule: WorkSchedule): Promise<void> {
    this.workScheduleByResource.set(workSchedule.resource.id, workSchedule)
  }

  public async count(): Promise<number> {
    return this.workScheduleByResource.size
  }

  public async findForResource(resource: Resource): Promise<WorkSchedule | undefined> {
    return this.workScheduleByResource.get(resource.id)
  }
}
