import { WorkSchedule } from '@/planning/domain/entity/work-schedule'
import { Resource } from '@/planning/domain/entity/resource'

export interface WorkScheduleRepository {
  save(workSchedule: WorkSchedule): Promise<void>

  count(): Promise<number>

  findForResource(resource: Resource): Promise<WorkSchedule | undefined>
}
