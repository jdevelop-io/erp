import { SetWorkScheduleRequest, SetWorkScheduleUseCase } from '@/planning/application/set-work-schedule'
import { WorkScheduleRepository } from '@/planning/domain/repository/work-schedule'
import { InMemoryWorkScheduleRepository } from '@/planning/infrastructure/repository/in-memory-work-schedule'
import { WeekDay } from '@/planning/domain/enum/week-day'
import { WorkDayStatus } from '../../../src/planning/domain/enum/work-day-status'
import { Resource } from '@/planning/domain/entity/resource'

describe('Set the work schedule', () => {
  let repository: WorkScheduleRepository
  let useCase: SetWorkScheduleUseCase

  const johnDoeResourceId = 'john.doe'
  const periods = [
    { start: '9:00 AM', end: '12:30 PM' },
    { start: '2:00 PM', end: '5:00 PM' },
  ]

  beforeEach(() => {
    repository = new InMemoryWorkScheduleRepository()
    useCase = new SetWorkScheduleUseCase(repository)
  })

  test('Resource is available on Monday to Friday', async () => {
    const request: SetWorkScheduleRequest = {
      resourceId: johnDoeResourceId,
      planning: {
        [WeekDay.Monday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Tuesday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Wednesday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Thursday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Friday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Saturday]: {
          status: WorkDayStatus.Unavailable,
          periods: [],
        },
        [WeekDay.Sunday]: {
          status: WorkDayStatus.Unavailable,
          periods: [],
        },
      },
    }
    const workSchedule = await useCase.execute(request)

    expect(workSchedule.resource.id).toBe(johnDoeResourceId)
    expect(workSchedule.planning[WeekDay.Monday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Tuesday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Wednesday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Thursday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Friday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Saturday]).toStrictEqual({
      status: WorkDayStatus.Unavailable,
      periods: [],
    })
    expect(workSchedule.planning[WeekDay.Sunday]).toStrictEqual({
      status: WorkDayStatus.Unavailable,
      periods: [],
    })

    expect(await repository.count()).toBe(1)
    expect(await repository.findForResource(Resource.of(johnDoeResourceId))).toBeDefined()
  })

  test('Resource is available on Monday to Thursday and flexible on Friday', async () => {
    const request: SetWorkScheduleRequest = {
      resourceId: johnDoeResourceId,
      planning: {
        [WeekDay.Monday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Tuesday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Wednesday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Thursday]: {
          status: WorkDayStatus.Working,
          periods,
        },
        [WeekDay.Friday]: {
          status: WorkDayStatus.Flexible,
          periods,
        },
        [WeekDay.Saturday]: {
          status: WorkDayStatus.Unavailable,
          periods: [],
        },
        [WeekDay.Sunday]: {
          status: WorkDayStatus.Unavailable,
          periods: [],
        },
      },
    }
    const workSchedule = await useCase.execute(request)

    expect(workSchedule.resource.id).toBe(johnDoeResourceId)
    expect(workSchedule.planning[WeekDay.Monday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Tuesday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Wednesday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Thursday]).toStrictEqual({
      status: WorkDayStatus.Working,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Friday]).toStrictEqual({
      status: WorkDayStatus.Flexible,
      periods,
    })
    expect(workSchedule.planning[WeekDay.Saturday]).toStrictEqual({
      status: WorkDayStatus.Unavailable,
      periods: [],
    })
    expect(workSchedule.planning[WeekDay.Sunday]).toStrictEqual({
      status: WorkDayStatus.Unavailable,
      periods: [],
    })

    expect(await repository.count()).toBe(1)
    expect(await repository.findForResource(Resource.of(johnDoeResourceId))).toBeDefined()
  })
})
