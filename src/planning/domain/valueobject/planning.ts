import { WeekDay } from '@/planning/domain/enum/week-day'
import { WorkDayConfig } from '@/planning/domain/valueobject/work-day-config'

export interface Planning {
  [WeekDay.Monday]: WorkDayConfig
  [WeekDay.Tuesday]: WorkDayConfig
  [WeekDay.Wednesday]: WorkDayConfig
  [WeekDay.Thursday]: WorkDayConfig
  [WeekDay.Friday]: WorkDayConfig
  [WeekDay.Saturday]: WorkDayConfig
  [WeekDay.Sunday]: WorkDayConfig
}
