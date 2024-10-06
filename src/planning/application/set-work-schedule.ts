import { WorkScheduleRepository } from '@/planning/domain/repository/work-schedule'
import { Planning } from '@/planning/domain/valueobject/planning'
import { WorkSchedule } from '@/planning/domain/entity/work-schedule'
import { Resource } from '@/planning/domain/entity/resource'

export interface SetWorkScheduleRequest {
  resourceId: string
  planning: Planning
}

export class SetWorkScheduleUseCase {
  constructor(private readonly repository: WorkScheduleRepository) {}

  public async execute(request: SetWorkScheduleRequest): Promise<WorkSchedule> {
    const resource = Resource.of(request.resourceId)

    const workSchedule = WorkSchedule.create(resource, request.planning)

    await this.repository.save(workSchedule)

    return workSchedule
  }
}
